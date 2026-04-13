<?php
namespace app\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;

use app\models\UtilsFitpro;

/**
 * Professional controller
 */
class ProfessionalController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index', 'view', 'testimonials', 'software', 
                            'cable-reference', 'cable-reference-pdf', 'cable-reference-ajax', 
                            'connectivity', 'drivers',
                        ],
                        // any user
                        //'roles' => ['?'],  // ? = Guest user
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'marketing-materials', 'printable-forms', 'product-overview', 
                            'product-specs', 'technical-manual',
                        ],
                        'roles' => ['@'],  // @ = Authenticated users
                    ],
                    [
                        'allow' => true,
                        'actions' => [ 
                            'create', 'update', 'delete', 'fitpro', 
                        ],
                        'roles' => ['@'],  // admin users
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role <= \app\models\User::ROLE_ADMIN;
                        }
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTestimonials()
    {
        $models = \app\models\Testimonial::find()->where(['like', 'tags', 'professional'])->all();

        return $this->render('/testimonial/index', [
            'models' => $models,
            'parent_breadcrumb_label' => 'Professionals',
            'parent_breadcrumb_route' => 'professional/index',
        ]);
    }

    public function actionProductOverview()
    {
        // Get general data
        $data         = $this->getProductFeatures();
        $dataProvider = new ArrayDataProvider([
            'allModels'    => $data,
            'pagination'   => [
                'pageSize' => 200,
            ],
            'sort' => [
                'attributes' => [
                    'Name', 
                    'Channels', 
                    'GainBands',
                    'ManualPrograms',
                    'NoiseReduction',
                    'AdaptiveDirectionalChannels',
                    'AutoEnvironmentSwitching',
                    'AdaptiveFeedbackCanceller',
                    'NumberOfMicrophones',
                    'Telecoil', 
                    'AutoTelecoil', 
                    'BatterySize',
                ],
            ],
        ]);
        
        return $this->render('product-overview', [
            'telecoil'     => $this->getProductSupportingTelecoil(),
            'autotelecoil' => $this->getProductSupportingAutoTelecoil(),
            'features'     => $this->getProductFeatures(),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProductSpecs($showall=0, $style='All')
    {
        $FilterByStyle  = (isset($style) ? $style : 'All');
        $ShowAllProducts = (isset($showall) && ($showall == 1) ? true : false);
    
        return $this->render('product-specs', [
                'ShowAllProducts'        => $ShowAllProducts,
                'FilterByStyle'          => $FilterByStyle,
            ]);
    }
    
    public function actionSoftware()
    {
        return $this->render('software');
    }

    public function actionDrivers()
    {
        return $this->render('drivers');
    }

    public function actionFitpro($days = 14, $version = UtilsFitpro::FITPRO_5)
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('fitpro-password-table', ['days' => $days, 'version' => $version]);
        } else {
            return $this->render('fitpro-password');
        }
    }
    
    public function actionSoftwareRequirements()
    {
        return $this->render('software-requirements');
    }
    
    public function actionTechnicalManual()
    {
        return $this->render('technical-manual');
    }
    
    public function actionPrintableForms()
    {
        return $this->render('printable-forms');
    }
    
    public function actionMarketingMaterials()
    {
        return $this->render('marketing-materials');
    }
    
    public function actionCableReferencePdf()
    {
        $this->actionCableReference(true);
    }
    
    public function actionCableReference($isPDF=false)
    {
        date_default_timezone_set('America/New_York');
        
        // Get general data
        $data           = $this->getProductData();
        $dataCables     = $this->getCableData();
        $dataConnectors = $this->getConnectorData();
        $dataProgBox    = $this->getProgBoxData();
        $dataHousing    = $this->getHousingData();
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 200,
            ],
            'sort' => [
                'attributes' => ['product', 'housing', 'cable', 'connector', 'programmer', 'notes'],
            ],
        ]);
        
        if ($isPDF) {
            Yii::$app->response->format = Response::FORMAT_RAW;     // Raw for PDF output
            return $this->render('cable-reference-pdf', [
                'data'           => $data,
                'dataCables'     => $dataCables,
                'dataConnectors' => $dataConnectors,
                'dataProgBox'    => $dataProgBox,
                'dataHousing'    => $dataHousing,
            ]);
        } else {
            if (Yii::$app->request->isPjax) {
                return $this->renderPartial('cable-reference', [
                    'found'          => $found,
                ]);
            } else {
                return $this->render('cable-reference', [
                    'dataProvider'   => $dataProvider,
                    'data'           => $data,
                    'dataCables'     => $dataCables,
                    'dataConnectors' => $dataConnectors,
                    'dataProgBox'    => $dataProgBox,
                    'dataHousing'    => $dataHousing,
                ]);
            }
        }
    }
    
    public function actionCableReferenceAjax()
    {
        $output = '';
        $docRootURL = 'https://cdn.auditiva.us'; //Yii::$app->urlManager->createUrl('');

        // Init AJAX data
        $found = [
            'product'    => '',
            'housing'    => '',
            'cable'      => '',
            'connector'  => '',
            'programmer' => '',
            'notes'      => '',
            'housing-image'    => 'blank.png',
            'connection-image' => 'blank.png',
            'cable-image'      => 'blank.png',
        ];
        
        // Handle AJAX data
        if (Yii::$app->request->post()) {
            $aProd = false;
            $aProd = $this->findProduct(Yii::$app->request->post('product'));
            if ($aProd != null) {
                $found['product']    = $aProd['product'];
                $found['housing']    = $aProd['housing'];
                $found['cable']      = $aProd['cable'];
                $found['connector']  = $aProd['connector'];
                $found['programmer'] = $aProd['programmer'];
                $found['notes']      = $aProd['notes'];
                $aHousing = $this->findHousing($aProd['housingName']); 
                $found['housing-image']    = $aHousing['image'];
                $found['connection-image'] = $aHousing['connection-image'];
                $aCable = $this->findCable($aProd['cable']); 
                $found['cable-image'] = $aCable['image'];
            }
            //$output .= '<div class="alert alert-success" role="alert">' . print_r($found, true) . '</div>';  // debug
            $output .= '<h3>'. $found['product'] . '</h3>';
            $output .= '<table class="table">';
            $output .= '<tr><td width="50"><b>Housing:</b></td><td>' . $found['housing']    . '</td></tr>';
            $output .= '<tr><td><b>Cable:      </b></td><td>' . $this->getCableLabel($found['cable']) .'</td></tr>';
            $output .= '<tr><td><b>Connector:  </b></td><td>' . $found['connector']  . '</td></tr>';
            $output .= '<tr><td><b>Programmer: </b></td><td>' . $found['programmer'] . '</td></tr>';
            $output .= '<tr><td><b>Notes:      </b></td><td>' . $found['notes']      . '</td></tr>';
            //$output .= '<p>&nbsp;</p>';
            $output .= '</table>';
            $output .= '<img src="' . $docRootURL . '/reference/' . $found['housing-image']    .'"  alt="Product Image"    class="img-thumbnail img-responsive" style="height: 150px">';
            $output .= '<img src="' . $docRootURL . '/reference/' . $found['connection-image'] .'"  alt="Connection Image" class="img-thumbnail img-responsive" style="height: 150px">';
            $output .= '<img src="' . $docRootURL . '/reference/' . $found['cable-image']      .'"  alt="Cable Image"      class="img-thumbnail img-responsive" style="height: 150px">';
        }
        return $output;
    }
    
    //---------------------------------------------------------------------------------------------
    // description: 
    // parameters :
    // return     :
    //---------------------------------------------------------------------------------------------
    private function getCableLabel($cableType) 
    {
      switch($cableType) {
        case 'Gray-3x':
            $label = '<span class="label label-color" style="background-color: #7d7d7d; color: yellow;">Gray-3x</span>';
            break;

        case 'Gray-4x':
            $label = '<span class="label label-color" style="background-color: #7d7d7d; color: #fff;">Gray-4x</span>';
            break;
            
        case 'Black-5x':
            $label = '<span class="label label-color" style="background-color: #000000; color: #fff;">Black-5x</span>';
            break;
            
        case 'Cable Pill 10A':
            // recursively call this function to get Left and Right labels
            $label = $this->getCableLabel($cableType . ' Left') . $this->getCableLabel($cableType . ' Right');
            break;
            
        case 'Cable Pill 10A Left':
            $label  = '<span class="label label-color" style="background-color: #0000ff; color: #fff;"><span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span> Left</span><br>';
            break;

        case 'Cable Pill 10A Right':
            $label = '<span class="label label-color" style="background-color: #ff0000; color: #fff;"><span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span> Right</span>';
            break;
            
        default:
            $label = '<span class="label label-color" style="background-color: #ff0000; color: #fff;">Unknown</span>';
            break;
      }
      return ($label); 
    }
    
    public function actionConnectivity($isPDF=false)
    {
        return $this->render('connectivity');
    }
    
    private function findProduct($aProductName)
    {
        $found = false;
        $data = $this->getProductData();
        foreach ($data as $key => $row) {
            $found = in_array($aProductName, $row);
            if ($found) { break; } // found
        }
        if ($found) {
            return $data[$key];
        } else {
            return null;
        }
    }
    
    private function findCable($aCableName)
    {
        $found = false;
        $data = $this->getCableData();
        foreach ($data as $key => $row) {
            //$found = in_array($aCableName, $row);
            $found = $this->stringContains($row['name'], $aCableName);
            if ($found) { break; } // found
        }
        if ($found) {
            return $data[$key];
        } else {
            return null;
        }
    }
    
    private function findHousing($aHousingName)
    {
        $found = false;
        $data = $this->getHousingData();
        foreach ($data as $key => $row) {
            $found = in_array($aHousingName, $row);
            if ($found) { break; } // found
        }
        if ($found) {
            return $data[$key];
        } else {
            return null;
        }
    }
    
    private function stringContains($aString, $aSubstring)
    {
        $result = (strpos($aString, $aSubstring) !== false);
        return $result;
    }
    
    private function getProductData()
    {
        return [
            ['product' => 'Arco OTE 2 / 6 / 6AD / 12',   'housing' => 'OTE', 'housingName' => 'OTE v4', 'cable' => 'Black-5x', 'connector' => 'Flexstrip XtendPads (4-pin)', 'programmer' => 'All', 'notes' => 'Must use Flexstrip XtendPads, not regular Flexstrip CS54.'],
            ['product' => 'Arco RIC 2 / 6 / 6AD / 12',   'housing' => 'RIC', 'housingName' => 'RIC v4', 'cable' => 'Black-5x', 'connector' => 'Flexstrip XtendPads (4-pin)', 'programmer' => 'All', 'notes' => 'Must use Flexstrip XtendPads, not regular Flexstrip CS54.'],
            ['product' => 'BTE 278P / 478P+',  'housing' => 'BTE', 'housingName' => 'BTE Classic', 'cable' => 'Gray-4x',  'connector' => 'None', 'programmer' => 'All', 'notes' => ''],
            ['product' => 'BTE D60P+', 'housing' => 'BTE', 'housingName' => 'BTE Classic', 'cable' => 'Gray-4x',  'connector' => 'None', 'programmer' => 'All', 'notes' => ''],
            ['product' => 'BTE D55AD',    'housing' => 'BTE', 'housingName' => 'BTE Euro', 'cable' => 'Black-5x', 
                'connector' => 'Flexstrip CS54 (4-pin) with Flexstrip "Pyramid" Adapter, or Flexstrip XtendPads (4-pin)', 
                'programmer' => 'All', 'notes' => ''
            ],
            ['product' => 'BTE D70HP',   'housing' => 'BTE', 'housingName' => 'BTE Classic', 'cable' => 'Gray-4x',  'connector' => 'None', 'programmer' => 'All', 'notes' => ''],
            ['product' => 'BTE D55P',    'housing' => 'BTE', 'housingName' => 'BTE Classic', 'cable' => 'Gray-4x',  'connector' => 'None', 'programmer' => 'All', 'notes' => ''],
            ['product' => 'Boost 4 / 6 / 12',      'housing' => 'Super Power',   'housingName' => 'BTE (Super Power)', 'cable' => 'Black-5x', 'connector' => 'None', 'programmer' => 'All', 'notes' => ''],
            ['product' => 'Briza 2 / 2+ / 2ER / 4 / AD / 12', 'housing' => 'OTE', 'housingName' => 'OTE v1', 'cable' => 'Gray-4x',  'connector' => 'Flexstrip CS54 (4-pin)', 'programmer' => 'All', 'notes' => ''],
            ['product' => 'Fino 2 / 4 / 6 / 12', 'housing' => 'RIC', 'housingName' => 'RIC v3', 'cable' => 'Black-5x', 'connector' => 'Flexstrip CS54 (4-pin)', 'programmer' => 'All', 'notes' => ''],
            ['product' => 'Fino 4 / AD (1st Gen)', 'housing' => 'RIC', 'housingName' => 'RIC v1', 'cable' => 'Gray-4x', 'connector' => 'Flexstrip CS54 (4-pin)', 'programmer' => 'HI-PRO, EMiniTec (v1)', 
                'notes' => 'NOAHlink or EMiniTec2 programmers will only work with special <span class="label label-color" style="background-color: #7d7d7d; color: yellow;">Gray-3x</span> cables.'
            ],
            [
                'product'     => 'IIC Family', 
                'housing'     => 'IIC',   
                'housingName' => 'IIC Beige (Custom)', 
                //'cable'       => 'Gray-4x',   // for flexstrip only products
                'cable'       => 'Cable Pill 10A', 
                //'connector'   => 'Flexstrip CS54 (4-pin)',    // for flexstrip only products
                'connector'   => 'None', 
                'programmer'  => 'All', 
                'notes'       => 'Cables are side and battery size specific. Select from: <span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span>, <span class="label label-color" style="background-color: orange; color: black;">Cable Pill 13</span>, <span class="label label-color" style="background-color: #8B4513; color: white;">Cable Pill 312</span>.  Some IIC products may use flexstrips instead, which require using <span class="label label-color" style="background-color: #7d7d7d; color: #fff;">Gray-4x</span> cables instead.',
            ],
            [
                'product'     => 'InstaFIT Zirc',
                'housing'     => 'Stock', 
                'housingName' => 'InstaFIT (IIC)', 
                'cable'       => 'Cable Pill 10A', 
                'connector'   => 'None', 
                'programmer'  => 'All', 
                'notes'       => 'Cables are side and battery size specific. Select from: <span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span>, <span class="label label-color" style="background-color: orange; color: black;">Cable Pill 13</span>, <span class="label label-color" style="background-color: #8B4513; color: white;">Cable Pill 312</span>'
            ],
            ['product' => 'InstaFIT 2ER / 4+ (with VC)',    'housingName' => 'InstaFIT (with VC)', 'housing' => 'Stock', 'cable' => 'Gray-4x', 
                'connector'  => '<span class="label label-color" style="background-color: #0000ff; color: #fff;">Battery Door 10A Pill Adapter (Left)</span><br><span class="label label-color" style="background-color: #ff0000; color: #fff;">Battery Door 10A Pill Adapter (Right)</span>', 
                'programmer' => 'All', 
                'notes'      => 'Adapters are side specific.'
            ],
            ['product' => 'InstaFIT 2ER / 4+ (without VC)', 'housingName' => 'InstaFIT (without VC)', 'housing' => 'Stock', 'cable' => 'Gray-4x', 'connector' => 'Flexstrip CS54 (4-pin)', 'programmer' => 'All', 'notes' => ''],
            //['product' => 'Smart 16', 'housing' => 'BTE', 'housingName' => 'ITE (Custom)', 'cable' => 'Gray-4x', 'connector' => 'None', 'programmer' => 'HI-PRO, EMiniTec (v1)', 
            //    'notes' => 'NOAHlink or EMiniTec2 programmers will work with special Gray-3x cables.'
            //],
            ['product' => 'Intuir 2 / 2FC / 4 / 4D', 'housing' => 'BTE', 'housingName' => 'BTE Int', 'cable' => 'Gray-4x', 'connector' => 'None', 'programmer' => 'HI-PRO, EMiniTec (v1)', 
                'notes' => 'NOAHlink or EMiniTec2 programmers will only work with special <span class="label label-color" style="background-color: #7d7d7d; color: yellow;">Gray-3x</span> cables.'
            ],
            ['product' => 'Intuir 2 / 2+ / 2FC / 2FC+ / 2ER / 4 / 4+ / 4D / 4AD / 6 / 12', 'housing' => 'ITE', 'housingName' => 'ITE (Custom)',   
                'cable' => 'Gray-4x', 'connector' => 'None or Flexstrip CS54 (4-pin)', 'programmer' => 'All', 'notes' => ''
            ],
            ['product' => 'Intuir (Stock Canal) 2 / 2+ / 2FC / 2FC+ / 2ER / 4 / 4+ / 4D / 4AD / 6 / 12', 'housing' => 'Stock', 'housingName' => 'Stock Canal', 
                'cable' => 'Cable Pill 10A', 'connector' => 'None', 'programmer' => 'All', 
                'notes' => 'Cables are side and battery size specific. Select from: <span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span>, <span class="label label-color" style="background-color: orange; color: black;">Cable Pill 13</span>, <span class="label label-color" style="background-color: #8B4513; color: white;">Cable Pill 312</span>'
            ],
            ['product' => 'Ligero 2P BTE / 2P+',   'housing' => 'BTE',           'housingName' => 'BTE Classic', 'cable' => 'Gray-4x',  'connector' => 'None', 'programmer' => 'All', 'notes' => ''],
            ['product' => 'Smart 16', 'housing' => 'ITE', 'housingName' => 'ITE (Custom)', 'cable' => 'Gray-4x', 'connector' => 'None or Flexstrip CS54 (4-pin)', 'programmer' => 'All', 'notes' => ''],
            ['product' => 'Veloz (1st Gen)', 'housing' => 'OTE', 'housingName' => 'OTE v2', 'cable' => 'Gray-4x', 'connector' => 'None', 'programmer' => 'All', 
                'notes' => 'Veloz products manufactured before Sep 2013 require <span class="label label-color" style="background-color: #7d7d7d; color: #fff;">Gray-4x</span> cables.  Products starting Sep 2013 (with serial number 13-1256xx or higher) require <span class="label label-color" style="background-color: #000000; color: #fff;">Black-5x</span> cables.'
            ],
            ['product' => 'Veloz 4 / 6 / 12', 'housing' => 'OTE', 'housingName' => 'OTE v2', 'cable' => 'Black-5x', 'connector' => 'None', 'programmer' => 'All', 
                'notes' => 'Veloz products manufactured before Sep 2013 require <span class="label label-color" style="background-color: #7d7d7d; color: #fff;">Gray-4x</span> cables.  Products starting Sep 2013 (with serial number 13-1256xx or higher) require <span class="label label-color" style="background-color: #000000; color: #fff;">Black-5x</span> cables.'
            ],
            [
                'product'     => 'Zirc', 
                'housing'     => 'IIC', 
                //'housingName' => 'Custom (IIC)', 
                'housingName' => 'IIC Black (Custom)',
                'cable'       => 'Cable Pill 10A', 
                'connector'   => 'None', 
                'programmer'  => 'All', 
                'notes'       => 'Cables are side and battery size specific. Select from: <span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span>, <span class="label label-color" style="background-color: orange; color: black;">Cable Pill 13</span>, <span class="label label-color" style="background-color: #8B4513; color: white;">Cable Pill 312</span>'
            ],
        ];
    }
    
    private function getCableData()
    {
        return [
            ['name' => 'Gray-4x',              'image' => 'cable-prog-Gray_4x-left.jpg',                        'compatible' => 'Unitron, Phonak, GNResound', 'notes' => 'Mostly used for custom products.'],
            ['name' => 'Black-5x',             'image' => 'cable-prog-Black_5x_StraightConnector-left.jpg',     'compatible' => 'Siemens, Oticon, Bernafon, PHSI',   'notes' => 'Mostly used for newer stock products.'],
            ['name' => 'Cable Pill 10A Left',  'image' => 'cable-prog-Black_4x_BatteryDoorConnector-left.jpg',  'compatible' => 'None',            'notes' => 'Cables are side and battery size specific. Select from: <span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span>, <span class="label label-color" style="background-color: orange; color: black;">Cable Pill 13</span>, <span class="label label-color" style="background-color: #8B4513; color: white;">Cable Pill 312</span>.'],
            ['name' => 'Cable Pill 10A Right', 'image' => 'cable-prog-Black_4x_BatteryDoorConnector-right.jpg', 'compatible' => 'None',            'notes' => 'Cables are side and battery size specific. Select from: <span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span>, <span class="label label-color" style="background-color: orange; color: black;">Cable Pill 13</span>, <span class="label label-color" style="background-color: #8B4513; color: white;">Cable Pill 312</span>.'],
            ['name' => 'Gray-3x',              'image' => 'cable-prog-Gray_3x-left.jpg',                        'compatible' => 'None',            'notes' => "Use only with NOAHlink or EMiniTec2 programmers reading Intuition BTE's or nVe OTE's."],
        ];
    }
    
    private function getConnectorData()
    {
        return [
            ['name' => 'Flexstrip CS54 (4-pin)',                'image' => 'connector-FlexstripCS54.jpg',                'notes' => 'Not compatible with all products that require flexstrips.  Use Flexstrip XtendPads for full compatibility.'],
            ['name' => 'Flexstrip XtendPads (4-pin)',           'image' => 'connector-FlexstripXtendPads.jpg',           'notes' => 'Compatible with any product that needs Flexstrip CS54 (4-pin). However, the reverse is not true. Recommended flexstrip for all products.'],
            //['name' => 'Flexstrip 8-inch (3-pin)',              'image' => 'connector-Flexstrip8inch.jpg',               'notes' => 'Not compatible with all products that require flexstrips.  Only use with Wireless Pico products.'],
            ['name' => 'Battery Door 10A Pill Adapter (Left)',  'image' => 'connector-BattDoor10APillAdapter-left.jpg',  'notes' => 'Must remove battery door. Adapter is side specific.'],
            ['name' => 'Battery Door 10A Pill Adapter (Right)', 'image' => 'connector-BattDoor10APillAdapter-right.jpg', 'notes' => 'Must remove battery door. Adapter is side specific.'],
            ['name' => 'Flexstrip "Pyramid" Adapter',           'image' => 'connector-FlexstripPyramidAdapter.jpg',      'notes' => 'Required in some products when using Flexstrip CS54 (4-pin). Must put flexstrip through "pyramid" adapter. "Pyramid" adapter not required when using Flexstrip XtendPads (4-pin).'],
        ];
    }
    
    private function getProgBoxData()
    {
        return [
            ['name' => 'HI-PRO (Classic)', 'prog-box-image' => 'ProgBox-HiPro-Classic.jpg', 'data-cable-image' => 'ProgBox-data-cable-serial-usbadapter.jpg', 'notes' => 'Null-modem serial cable, with USB-serial adapter'],
            ['name' => 'HI-PRO (USB)',     'prog-box-image' => 'ProgBox-HiPro-USB-v1.jpg',  'data-cable-image' => 'ProgBox-data-cable-usb.jpg',               'notes' => 'USB cable'],
            ['name' => 'HI-PRO 2 (USB)',   'prog-box-image' => 'ProgBox-HiPro-USB-v2.jpg',  'data-cable-image' => 'ProgBox-data-cable-usb.jpg',               'notes' => 'USB cable'],
            ['name' => 'NOAHlink',         'prog-box-image' => 'ProgBox-NOAHlink.jpg',      'data-cable-image' => 'ProgBox-data-cable-bluetooth.jpg',         'notes' => 'Wireless Bluetooth adapter (no cable)'],
            ['name' => 'EMiniTec (v1)',    'prog-box-image' => 'ProgBox-EMiniTec-v1.jpg',   'data-cable-image' => 'ProgBox-data-cable-usb.jpg',               'notes' => 'USB cable'],
            ['name' => 'EMiniTec 2',       'prog-box-image' => 'ProgBox-EMiniTec-v2.jpg',   'data-cable-image' => 'ProgBox-data-cable-usb.jpg',               'notes' => 'USB cable'],
            //['name' => 'FittingLINK',      'prog-box-image' => 'ProgBox-FittingLINK.jpg',   'data-cable-image' => 'ProgBox-data-cable-usb.jpg',               'notes' => 'Wireless adapter (no cable), or USB cable'],
        ];
    }
    
    private function getHousingData()
    {
        return [
            ['name' => 'BTE Classic',           'type' => 'BTE',               'image' => 'icon-housing-bte-simplex.png',    'connection-image' => 'housing-conn-BTE_Boxy-Port.jpg',            'cable' => 'Gray-4x',        'connector' => 'None',                            'notes' => 'Use socket.'],
            ['name' => 'BTE Euro',              'type' => 'BTE',               'image' => 'icon-housing-bte-bumpy.png',      'connection-image' => 'housing-conn-BTE_Bumpy-Flexstrip.jpg',      'cable' => 'Black-5x',       'connector' => 'Flexstrip CS54 (4-pin) with Flexstrip "Pyramid" Adapter, or Flexstrip XtendPads (4-pin)', 'notes' => ''],
            ['name' => 'BTE Int',               'type' => 'BTE',               'image' => 'icon-housing-bte.png',            'connection-image' => 'housing-conn-BTE_Classic-Port.jpg',         'cable' => 'Gray-4x',        'connector' => 'None',                            'notes' => 'Use socket. NOAHlink or EMiniTec2 programmers will only work with special <span class="label label-color" style="background-color: #7d7d7d; color: yellow;">Gray-3x</span> cables.'],
            ['name' => 'BTE (Super Power)',     'type' => 'BTE (Super Power)', 'image' => 'icon-housing-octane.png',         'connection-image' => 'housing-conn-BTE_SuperPower-Port.jpg',      'cable' => 'Black-5x',       'connector' => 'None',                            'notes' => 'Use socket inside battery compartment.'],
            //['name' => 'BTE Nano',              'type' => 'BTE',               'image' => 'icon-housing-bte-nano.png',       'connection-image' => 'housing-conn-BTE_Nano-Port.jpg',            'cable' => 'Black-5x',       'connector' => 'None',   'notes' => ''],
            //['name' => 'BTE PowerBTE',          'type' => 'BTE',               'image' => 'icon-housing-bte-powerbte.png',        'connection-image' => 'housing-conn-BTE_PowerBTE-Port.jpg',        'cable' => 'Black-5x',       'connector' => 'None',   'notes' => ''],
            ['name' => 'InstaFIT (with VC)',    'type' => 'Stock',             'image' => 'icon-housing-instafit-vc-beige.png',   'connection-image' => 'housing-conn-CIC_InstaFIT-vc-BatteryDoor.jpg',    'cable' => 'Gray-4x',        'connector' => '<span class="label label-color" style="background-color: #0000ff; color: #fff;">Battery Door 10A Pill Adapter (Left)</span><br><span class="label label-color" style="background-color: #ff0000; color: #fff;">Battery Door 10A Pill Adapter (Right)</span>',        'notes' => 'Must remove battery door. Adapter is side specific. '],
            ['name' => 'InstaFIT (without VC)', 'type' => 'Stock',             'image' => 'icon-housing-instafit-novc-beige.png', 'connection-image' => 'housing-conn-CIC_InstaFIT-Flexstrip.jpg',         'cable' => 'Gray-4x',        'connector' => 'Flexstrip CS54 (4-pin), or Flexstrip XtendPads (4-pin)',          'notes' => 'Use flexstrip.'],
            ['name' => 'InstaFIT (IIC)',        'type' => 'Stock',             'image' => 'icon-housing-instafit-novc-black.png', 'connection-image' => 'housing-conn-IIC_InstaFIT-black-BatteryDoor.jpg', 'cable' => 'Cable Pill 10A', 'connector' => 'None',                            'notes' => 'Must remove battery door. Cables are side and battery size specific. Select from: <span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span>, <span class="label label-color" style="background-color: orange; color: black;">Cable Pill 13</span>, <span class="label label-color" style="background-color: #8B4513; color: white;">Cable Pill 312</span>.'],
            ['name' => 'ITE (Custom)',          'type' => 'ITE (Custom)',      'image' => 'icon-housing-custom.png',           'connection-image' => 'housing-conn-Custom_Shell-Custom.jpg',               'cable' => 'Gray-4x',        'connector' => 'None, or Flexstrip CS54 (4-pin) / Flexstrip XtendPads (4-pin)',   'notes' => 'Use socket or flexstrip, depending how it was ordered.'],
            ['name' => 'IIC Beige (Custom)',    'type' => 'IIC (Custom)',      'image' => 'icon-housing-custom-iic-beige.png', 'connection-image' => 'housing-conn-Custom_Shell-IIC-beige-BatteryDoor.jpg','cable' => 'Gray-4x',        'connector' => 'None, or Flexstrip CS54 (4-pin) / Flexstrip XtendPads (4-pin)',   'notes' => 'Use socket or flexstrip, depending how it was ordered.'],
            ['name' => 'IIC Black (Custom)',    'type' => 'IIC (Custom)',      'image' => 'icon-housing-custom-iic-black.png', 'connection-image' => 'housing-conn-Custom_Shell-IIC-black-BatteryDoor.jpg','cable' => 'Cable Pill 10A', 'connector' => 'None',   'notes' => 'Must remove battery door. Cables are side and battery size specific. Select from: <span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span>, <span class="label label-color" style="background-color: orange; color: black;">Cable Pill 13</span>, <span class="label label-color" style="background-color: #8B4513; color: white;">Cable Pill 312</span>.'],
            ['name' => 'MRIC',                  'type' => 'RIC',               'image' => 'icon-housing-cue-mric.png',       'connection-image' => 'blank.png',                                 'cable' => 'Black-5x',       'connector' => 'Flexstrip CS54 (4-pin)',          'notes' => 'Slightly open battery door while inserting flexstrip, then completely close the door.'],
            ['name' => 'OTE v1',                'type' => 'OTE',               'image' => 'icon-housing-sparo-open.png',     'connection-image' => 'housing-conn-OTE_v1-Flexstrip.jpg',         'cable' => 'Gray-4x',        'connector' => 'Flexstrip CS54 (4-pin), or Flexstrip XtendPads (4-pin)',          'notes' => 'Insert flexstrip in slit below push-button in battery door, and completely close the door.'],
            ['name' => 'OTE v2',                'type' => 'OTE',               'image' => 'icon-housing-flx.png',            'connection-image' => 'housing-conn-OTE_v2-Port.jpg',              'cable' => 'Black-5x',       'connector' => 'Flexstrip CS54 (4-pin), or Flexstrip XtendPads (4-pin)',          'notes' => 'Use socket. Products manufactured before Sep 2013 require Gray-4x cables. Products starting Sep 2013 (with serial number 13-1256xx or higher) require Black-5x cables.'],
            ['name' => 'OTE v4',                'type' => 'OTE',               'image' => 'icon-housing-arro-open.png',      'connection-image' => 'housing-conn-OTE_v4-Flexstrip.jpg',         'cable' => 'Black-5x',       'connector' => 'Flexstrip XtendPads (4-pin)',     'notes' => 'Must use Flexstrip XtendPads (4-pin) only. Slightly open battery door while inserting flexstrip, then completely close the door.'],
            //['name' => 'RIC v3',              'type' => 'RIC',               'image' => 'icon-housing-nve.png',            'connection-image' => 'housing-conn-OTE_v3-Flexstrip.jpg',         'cable' => 'Gray-4x',        'connector' => 'Flexstrip CS54 (4-pin), or Flexstrip XtendPads (4-pin)',          'notes' => 'Slightly open battery door while inserting flexstrip, then completely close the door.'],
            ['name' => 'RIC v1',                'type' => 'RIC',               'image' => 'icon-housing-nve.png',            'connection-image' => 'housing-conn-RIC_v1-Flexstrip.jpg',         'cable' => 'Gray-4x',        'connector' => 'Flexstrip CS54 (4-pin), or Flexstrip XtendPads (4-pin)',          'notes' => 'Distinguishing characteristic: bump on each side. Slightly open battery door while inserting flexstrip, then completely close the door. NOAHlink or EMiniTec2 programmers will only work with special <span class="label label-color" style="background-color: #7d7d7d; color: yellow;">Gray-3x</span> cables.'],
            ['name' => 'RIC v3',                'type' => 'RIC',               'image' => 'icon-housing-iric.png',           'connection-image' => 'housing-conn-RIC_v3-Flexstrip.jpg',         'cable' => 'Black-5x',       'connector' => 'Flexstrip CS54 (4-pin), or Flexstrip XtendPads (4-pin)',          'notes' => 'Distinguishing characteristic: depression on each side. Slightly open battery door while inserting flexstrip, then completely close the door.'],
            ['name' => 'RIC v4',                'type' => 'RIC',               'image' => 'icon-housing-arro-ric.png',       'connection-image' => 'housing-conn-RIC_v4-Flexstrip.jpg',         'cable' => 'Black-5x',       'connector' => 'Flexstrip XtendPads (4-pin)',     'notes' => 'Must use Flexstrip XtendPads (4-pin) only. Slightly open battery door while inserting flexstrip, then completely close the door.'],
            //['name' => 'RIC Pico',              'type' => 'RIC',               'image' => 'icon-housing-ric-pico.png',       'connection-image' => 'housing-conn-RIC-Pico-Flextrip.jpg',        'cable' => 'Black-5x',       'connector' => 'None',   'notes' => ''],
            ['name' => 'Stock Canal',           'type' => 'Stock',             'image' => 'icon-housing-stock-canal.png',    'connection-image' => 'housing-conn-Stock-Canal-BatteryDoor.jpg',  'cable' => 'Cable Pill 10A', 'connector' => 'None',   'notes' => 'Must remove battery door. Cables are side and battery size specific. Select from: <span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span>, <span class="label label-color" style="background-color: orange; color: black;">Cable Pill 13</span>, <span class="label label-color" style="background-color: #8B4513; color: white;">Cable Pill 312</span>.'],
        ]; 
    }
    
    //-------------------------------------------------------------------------------------------------
    // description: Get file list for the specified path (filtered by the specified extension).
    //              Eg: $files = GetFileList("/catalog", "*.pdf");
    //                  echo "<br><pre>" . print_r($files, true) . "</pre><p>"; 
    // parameters : $aBaseDir (no trailing slash), $aFilePattern (eg: *.jpg)
    // return     : $files (string array)
    //-------------------------------------------------------------------------------------------------
    function getFileList($aBaseDir, $aFilePattern)
    {
        $filepattern = $_SERVER["DOCUMENT_ROOT"] . $aBaseDir . "/". $aFilePattern;
        //$filepattern = $aBaseDir . "/". $aFilePattern;
        echo $filepattern;
            
        $files       = @glob($filepattern);
        $filestotal  = @count($files);
        $curfile     = "";

        //for ($filecurcnt = 0; $filecurcnt < $filestotal; $filecurcnt++)
        //{
        //    $curfile = $files[$filecurcnt];
        //    echo $curfile . "<br>"; // here you can get full address of files (one by one)
        //}
        return $files;
    }

    //-------------------------------------------------------------------------------------------------
    // description: Get file and folder list for the specified path (filtered by the specified extension).
    //              Eg: 
    //                $files = array();
    //                $folders = array();
    //                GetFileAndFolderList("/catalog", "pdf", $files, $folders);
    //                echo "<br><pre>" . print_r($files, true) . "</pre><p>"; 
    // parameters : $aBaseDir (no trailing slash), $aFileType (no leading dot), $Files_Result (output array), $Folders_Result (output array)
    // return     : void
    //-------------------------------------------------------------------------------------------------
    function getFileAndFolderList($aBaseDir, $aFileType, &$Files_Result, &$Folders_Result)
    {
        $aBaseDir = rtrim($aBaseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;  // add trailing slash
        
        $Folders_Result = array();
        $Files_Result   = array();
        if (is_dir($aBaseDir)) {
            $dirhandle = opendir($aBaseDir);
            
            while (($file = readdir($dirhandle)) !== false) {
                if($file != "." and $file != "..") {
                    if(is_dir($aBaseDir . $file)) {  
                        $Folders_Result[] = $file;
                    } else {
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        //$filename = pathinfo($file, PATHINFO_FILENAME); 
                        if ($ext == $aFileType) {
                            $Files_Result[] = $file;
                        }
                    }
                }
            }
            closedir($dirhandle);
            
            // sort, just in case
            if (defined('SORT_NATURAL')) {  // supported in PHP 5.4.0 or newer only
                if (isset($Files_Result))   { sort($Files_Result,   SORT_NATURAL | SORT_FLAG_CASE); }
                if (isset($Folders_Result)) { sort($Folders_Result, SORT_NATURAL | SORT_FLAG_CASE); }
            } else {
                if (isset($Files_Result))   { sort($Files_Result,   SORT_STRING); }
                if (isset($Folders_Result)) { sort($Folders_Result, SORT_STRING); }
            }
        } 
    }
    
    private function getProductSupportingTelecoil()
    {
        return [
            "Analog+"           => "Unavailable",
            "Arco 2 OTE"        => "Optional",
            "Arco 2 RIC"        => "Standard",
            "Arco 4 OTE"        => "Optional",
            "Arco 4 RIC"        => "Optional",
            "Arco 6 OTE"        => "Optional",
            "Arco 6 AD OTE"     => "Optional",
            "Arco 6 RIC"        => "Standard",
            "Arco 12 OTE"       => "Optional",
            "Arco 12 RIC"       => "Standard",
            "Veloz 2"           => "Standard",
            "Zirc"              => "Unavailable",
            "Veloz"             => "Standard",
            "Veloz 4"           => "Standard",
            "Veloz 6"           => "Standard",
            "Veloz 12"          => "Standard",
            "Intuir 2"          => "Optional",
            "Intuir 2 BTE"      => "Standard",
            "Intuir 2+"         => "Optional",
            "Intuir 2+ BTE"     => "Standard",
            "Intuir 2FC"        => "Optional",
            "Intuir 2FC BTE"    => "Standard",
            "Intuir 4"          => "Optional",
            "Intuir 4+"         => "Optional",
            "Intuir 4+ BTE"     => "Standard",
            "Intuir 4D BTE"     => "Standard",
            "Intuir 4AD"        => "Optional",
            "Intuir 4AD BTE"    => "Standard",
            "Intuir 6"          => "Optional",
            "Intuir 12"         => "Optional",
            "Fino 2"            => "Standard",
            "Fino 4"            => "Standard",
            "Fino 6"            => "Standard",
            "Fino 12"           => "Standard",
            "Fino 4 (1st gen)"  => "Standard",
            "Fino AD (1st gen)" => "Standard",
            "Boost T"           => "Standard",
            "Boost 4"           => "Standard",
            "Boost 6"           => "Standard",
            "Boost 12"          => "Standard",
            "Briza 2"           => "Optional",
            "Briza 2+"          => "Optional",
            "Briza 2ER"         => "Optional",
            "Briza 4"           => "Optional",
            "Briza AD"          => "Optional",
            "Briza 12"          => "Optional",
            "Ligero BTE"        => "Optional",
            "Ligero 2P BTE"     => "Optional",
            "BTE 278P+"         => "Standard",
            "BTE D60P+"         => "Standard",
            "BTE D60"           => "Standard",
            "BTE D4P"           => "Standard",
            "BTE D70HP"          => "Standard",
            "BTE D55P"           => "Standard",
            "BTE 55AD"           => "Standard",
        ];
    }
    
    private function getProductSupportingAutoTelecoil()
    {
        return [
            "Intuir 2"    => "Optional",
            "Intuir 2+"   => "Optional",
            "Intuir 2FC"  => "Optional",
            "Intuir 2FC+" => "Optional",
            "Intuir 2ER"  => "Optional",
            "Intuir 4+"   => "Optional",
            "Intuir 4AD"  => "Optional",
            "Intuir 6"    => "Optional",
            "Intuir 12"   => "Optional",
            "Boost T"     => "Optional",
            "Boost 4"     => "Optional",
            "Boost 12"    => "Optional",
        ];
    }

    private function getProductFeatures()
    {
        // Product Analog+
        $products = [ 
            'prod_AnalogPlus' => [
                'Name'                        => "Analog+",
                'ProductID'                   => 'prod_AnalogPlus',
                'CircuitFamily'               => "Essential",
                'CircuitID'                   => 'Essential',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 1,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 1,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Unavailable',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => false,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 1,
                'Housing'                     => 'Custom',
                'Housings'                    => ['Custom'],
                'HousingIDs'                  => ['Custom_Shell'],
                'HousingFilename'             => "images/icons/icon-housing-custom.png",
                'HousingColor'                => ['Beige'],
                'ProgrammerCable'             => 'None',
                'ConnectivityFilename'        => "images/accessories/housing-conn-Custom_Shell-Custom.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => false,
                'SupportedVCTypes' => ['None', 'Analog'],
                'Styles'           => ['CIC', 'MiniCIC', 'MiniCanal', 'Canal', 'HalfShell', 'FullShell'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 59, 57, 56, 55, 57, 63, 49, 51, 23, 18 ],
                'Options'          => [],
            ],
            
            //  Arro 6 OTE
            'prod_Arro6OTE' => [ 
                'IsVisible'                   => false,
                'Name'                        => "Arco 6 OTE",
                'ProductID'                   => 'prod_Arro6OTE',
                'ProductFamily'               => "Arco",
                'CircuitFamily'               => "Audion6",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Premium',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'OTE312',
                'Housings'                    => ['OTE312'],
                'HousingIDs'                  => ['OTE_v4'],
                'HousingFilename'             => "images/icons/icon-housing-arro-open.png",
                'HousingColor'                => [
                    'Beige',
                    'Mocha',
                    'Gray',
                ],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v4-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 41, 41, 43, 50, 55, 80, 85, 90, 90, 90 ],
                'Options'          => ['Telecoil'],
            ],


            // Arro 6 RIC
            'prod_Arro6RIC' => [  
                'IsVisible'                   => false,
                'Name'                        => "Arco 6 RIC",
                'ProductID'                   => 'prod_Arro6RIC',
                'ProductFamily'               => "Arco",
                'CircuitFamily'               => "Audion6",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Premium',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => ['NoSelfLearning'],
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'RIC312',
                'Housings'                    => ['RIC312'],
                'HousingIDs'                  => ['RIC_v4'],
                'HousingFilename'             => "images/icons/icon-housing-arro-ric.png",
                'HousingColor'                => [
                    'Beige',
                    'Mocha',
                    'Gray',
                ],
                'ProgrammerCable'             => ['Black_5x'],
                'ConnectivityFilename'        => "images/accessories/housing-conn-RIC_v4-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,

                'SupportedVCTypes' => ['None'],

                // Style
                'Styles'=> ['RIC'],

                // Fitting Range
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [ 41, 41, 43, 50, 55, 80, 85, 90, 90, 90 ],

                // Options
                'Options' => ["Telecoil"],

            ],
            
            
            //  Arro 2 OTE
            'prod_Arro2OTE' => [ 
                'Name'                        => "Arco 2 OTE",
                'ProductID'                   => 'prod_Arro2OTE',
                'ProductFamily'               => "Arco",
                'CircuitFamily'               => "SpinNR",
                'CircuitID'                   => 'SpinNR',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'NumberOfMicrophones'         => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'OTE312',
                'Housings'                    => ['OTE312'],
                'HousingIDs'                  => ['OTE_v4'],
                'HousingFilename'             => "images/icons/icon-housing-arro-open.png",
                'HousingColor'                => [
                    'Beige',
                    'Mocha',
                    'Gray'
                ],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v4-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 41, 41, 43, 50, 55, 80, 85, 90, 90, 90 ],
                'Options'          => ['Telecoil'],
            ],
            
            // Arro 2 RIC
            'prod_Arro2RIC' => [
                'Name'                        => "Arco 2 RIC",
                'ProductID'                   => 'prod_Arro2RIC',
                'ProductFamily'               => "Arco",
                'CircuitFamily'               => "SpinNR",
                'CircuitID'                   => 'SpinNR',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'RIC312',
                'Housings'                    => ['RIC312'],
                'HousingIDs'                  => ['RIC_v4'],
                'HousingFilename'             => "images/icons/icon-housing-arro-ric.png",
                'HousingColor'                => [
                    'Beige',
                    'Mocha',
                    'Gray',
                ],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-RIC_v4-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['RIC'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 41, 41, 43, 50, 55, 80, 85, 90, 90, 90 ],
                'Options'          => ['Telecoil'],
            ],
            
            //  Arro 6 OTE
            'prod_Arro6OTE' => [ 
                'IsVisible'                   => false,
                'Name'                        => "Arco 6 OTE",
                'ProductID'                   => 'prod_Arro6OTE',
                'ProductFamily'               => "Arco",
                'CircuitFamily'               => "Audion6",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Premium',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'OTE312',
                'Housings'                    => ['OTE312'],
                'HousingIDs'                  => ['OTE_v4'],
                'HousingFilename'             => "images/icons/icon-housing-arro-open.png",
                'HousingColor'                => [
                    'Beige',
                    'Mocha',
                    'Gray',
                ],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v4-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 41, 41, 43, 50, 55, 80, 85, 90, 90, 90 ],
                'Options'          => ['Telecoil'],
            ],
            
            //  Arro 6 AD OTE
            'prod_Arro6ADOTE' => [ 
                'Name'                        => "Arco 6 AD OTE",
                'ProductID'                   => 'prod_Arro6ADOTE',
                'ProductFamily'               => "Arco",
                'CircuitFamily'               => "Audion6",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Premium2',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'OTE312',
                'Housings'                    => ['OTE312'],
                'HousingIDs'                  => ['OTE_v4'],
                'HousingFilename'             => "images/icons/icon-housing-arro-open.png",
                'HousingColor'                => [
                    'Beige',
                    'Mocha',
                    'Gray',
                ],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v4-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'          => ['OTE'],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [ 41, 41, 43, 50, 55, 80, 85, 90, 90, 90 ],
                'Options'         => ['Telecoil'],
            ],
            
            //  Arro 6 AD RIC
            'prod_Arro6ADRIC' => [ 
                'Name'                        => "Arco 6 RIC",
                'ProductID'                   => 'prod_Arro6ADRIC',
                'ProductFamily'               => "Arco",
                'CircuitFamily'               => "Audion6",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Premium2',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'RIC312',
                'Housings'                   => ['RIC312'],
                'HousingIDs'                  => ['RIC_v4'],
                'HousingFilename'             => "images/icons/icon-housing-arro-ric.png",
                'HousingColor'                => [
                   'Beige',
                   'Mocha',
                   'Gray',
                ],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-RIC_v4-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['RIC'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 41, 41, 43, 50, 55, 80, 85, 90, 90, 90 ],
                'Options'          => ['Telecoil'],
            ],
            
            //  Arro 12 OTE
            'prod_Arro12OTE' => [ 
                'Name'                        => "Arco 12 OTE",
                'ProductID'                   => 'prod_Arro12OTE',
                'ProductFamily'               => "Arco",
                'CircuitFamily'               => "Audion8",
                'CircuitID'                   => 'Audion8',
                'TechnologyLevel'             => 'Premium3',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 8,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'OTE312',
                'Housings'                    => ['OTE312'],
                'HousingIDs'                  => ['OTE_v4'],
                'HousingFilename'             => "images/icons/icon-housing-arro-open.png",
                'HousingColor'                => [
                    'Beige',
                    'Mocha',
                    'Gray',
                ],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v4-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 41, 41, 43, 50, 55, 80, 85, 90, 90, 90 ],
                'Options'          => ['Telecoil'],
            ],
            
            //  Arro 12 RIC
            'prod_Arro12RIC' => [ 
                'Name'                       => "Arco 12 RIC",
                'ProductID'                   => 'prod_Arro12RIC',
                'ProductFamily'               => "Arco",
                'CircuitFamily'               => "Audion8",
                'CircuitID'                   => 'Audion8',
                'TechnologyLevel'             => 'Premium3',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 8,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'RIC312',
                'Housings'                    => ['RIC312'],
                'HousingIDs'                  => ['RIC_v4'],
                'HousingFilename'             => "images/icons/icon-housing-arro-ric.png",
                'HousingColor'                => [
                    'Beige',
                    'Mocha',
                    'Gray',
                ],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-RIC_v4-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['RIC'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 41, 41, 43, 50, 55, 80, 85, 90, 90, 90 ],
                'Options'          => ['Telecoil'],
            ],
            
            //  Product Cue
            'prod_Cue' => [ 
                'Name'                        => "Zirc",         // default name
                'ProductID'                   => 'prod_Cue',
                'CircuitFamily'               => "Cue",         // Should be: Overtus/Ethos
                'CircuitID'                   => 'Ethos',
                'TechnologyLevel'             => 'Premium',
                'BatterySize'                 => 'Multiple', // TBatterySize.Size312Brown, // for Cue MRIC  // TBatterySize.Size10AYellow,  // for Cue MiniCIC
                'Channels'                    => 8,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => false,
                'AutoTelecoil'                => 'Unavailable',
                'Telecoil'                    => 'Unavailable',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'CustomMiniBTE',
                'HousingIDs'                  => ['IIC_Cue'],
                'Housings'                    => ['Custom', 'MiniBTE'],
                'HousingFilename'             => "images/icons/icon-housing-custom-minicic.png",
                'HousingColor'                => [
                    'Beige',
                    'Brown', 
                    'LightBrown',
                    'Tan', 
                    'Black', 
                    'Red', 
                    'Blue',  
                    //'Champagne', // for Cue MRIC only
                    //'Titanium', // for Cue MRIC only
                ],
                'ProgrammerCable'             => 'Black_5x_BatteryDoorConnector',     // Cue IIC (aka Xtreme) only
                'ConnectivityFilename'        => "images/accessories/housing-conn-IIC_Cue-BatteryDoor.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'Styles'          => ['MiniCIC'],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [57, 58, 58, 57, 58, 58, 62, 60, 47, 28],
                'Options'         => ['Style: MiniCIC'],
            ],
            
            //  Product Flx (Legacy)
            'prod_Flx' => [ 
                'Name'                        => "Veloz",
                'ProductID'                   => 'prod_Flx',
                'ProductFamily'               => "Veloz",
                'CircuitFamily'               => "Ethos",
                'CircuitID'                   => 'Ethos',
                'TechnologyLevel'             => 'Premium',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 8,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'HFX',
                'Housings'                    => ['HFX'],
                'HousingIDs'                  => ['OTE_v2'],
                'HousingFilename'             => "images/icons/icon-housing-flx.png",
                'HousingColor'                => ['Beige', 'Gray',],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v2-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Digital'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [58, 65, 68, 71, 74, 71, 64, 75, 49, 34],
                'Options'          => ['BTEEarhook'],
            ],
            
            //  Product Flx 6
            'prod_Flx6' => [ 
                'Name'                        => "Veloz 6",
                'ProductID'                   => 'prod_Flx6',
                'ProductFamily'               => "Veloz",
                'CircuitFamily'               => "Audion6",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Mid2',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'HFX',
                'Housings'                    => ['HFX'],
                'HousingIDs'                  => ['OTE_v2'],
                'HousingFilename'             => "images/icons/icon-housing-flx.png",
                'HousingColor'                => ['Beige','Gray',],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v2-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Digital'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [58, 65, 68, 71, 74, 71, 64, 75, 49, 34],
                'Options'          => ['BTEEarhook'],
            ],
            
            //  Product Flx 4
            'prod_Flx4' => [ 
                'Name'                          => "Veloz 4",
                'ProductID'                     => 'prod_Flx4',
                'ProductFamily'                 => "Veloz",
                'CircuitFamily'                 => "Audion4",
                'CircuitID'                     => 'Audion4',
                'TechnologyLevel'               => 'Mid',
                'BatterySize'                   => 'Size312Brown',
                'Channels'                      => 4,
                'AutoEnvironmentSwitching'      => 0,
                'AdaptiveDirectionalChannels'   => 0,
                'GainBands'                     => 12,
                'NoiseReduction'                => true,
                'BluetoothCompatible'           => false,
                'AudioLoopSystemCompatible'     => false,
                'FMLoopSystemCompatible'        => true,
                'PhoneLoopSystemCompatible'     => false,
                'Telecoil'                      => 'Standard',
                'AutoTelecoil'                  => 'Unavailable',
                'AdaptiveFeedbackCanceller'     => true,
                'DataloggerType'                => 'None',
                'WindManager'                   => false,
                'TinnitusNoiseGenerator'        => false,
                'ManualPrograms'                => 4,
                'Housing'                       => 'HFX',
                'Housings'                      => ['HFX'],
                'HousingIDs'                    => ['OTE_v2'],
                'HousingFilename'               => "images/icons/icon-housing-flx.png",
                'HousingColor'                  => ['Beige', 'Gray',],
                'ProgrammerCable'               => 'Black_5x',
                'ConnectivityFilename'          => "images/accessories/housing-conn-OTE_v2-Port.jpg",
                'IsLegacy'                      => false,
                'IsStockProduct'                => true,
                'SupportedVCTypes' => ['Digital'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 61, 72, 73, 69, 65, 68, 67, 67, 54, 43 ],
                'Options'          => ['BTEEarhook'],
            ],
            
            //  Product Flx 12
            'prod_Flx12' => [
                'Name'                        => "Veloz 12",
                'ProductID'                   => 'prod_Flx12',
                'ProductFamily'               => "Veloz",
                'CircuitFamily'               => "Ethos",
                'CircuitID'                   => 'Ethos',
                'TechnologyLevel'             => 'Premium2',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 8,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'HFX',
                'Housings'                    => ['HFX'],
                'HousingIDs'                  => ['OTE_v2'],
                'HousingFilename'             => "images/icons/icon-housing-flx.png",
                'HousingColor'                => ['Beige', 'Gray',],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v2-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Digital'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [58, 65, 68, 71, 74, 71, 64, 75, 49, 34],
                'Options'          => ['BTEEarhook'],
            ],
            
            //  Product Intuition 2
            'prod_Intuition2' => [ 
                'Name'                        => "Intuir 2",
                'ProductID'                   => 'prod_Intuition2',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "DigitalOne2CT",
                'CircuitID'                   => 'DigitalOne2CT',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 10,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => false,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                   => ['Custom', 'BTE'],
                'HousingIDs'                  => ['Custom_Shell', 'BTE_Int'],
                'HousingFilename'             => "images/icons/icon-housing-custom-bte.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown',  
                   'LightBrown',  
                   'Tan', 
                   'Red', 
                   'Blue'
                 ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-Custom_Shell-Custom.jpg",
                'IsLegacy'                    => true,
                'Styles' => ['CIC', 'MiniCanal', 'Canal', 'HalfShell', 'FullShell', 'BTE'],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [ 59, 57, 56, 55, 57, 63, 49, 51, 23, 18 ],
                'Options'=> [
                   'Telecoil',
                   'AutoTelecoil',
                   'PlusPower',
                   'Super60',
                   'Super70',
                   'WaxSystem', 
                   "HF3/NWK"
                ],
            ],
            
            //  Product Intuition 2+
            'prod_Intuition2Plus' => [
                'Name'                        => "Intuir 2+",
                'ProductID'                   => 'prod_Intuition2Plus',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "SpinNR",
                'CircuitID'                   => 'SpinNR',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => false,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                    => ['Custom', 'BTE'],
                'HousingIDs'                  => ['Custom_Shell', 'BTE_Int'],
                'HousingFilename'             => "images/icons/icon-housing-custom.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown',  
                   'LightBrown',  
                   'Tan', 
                   'Red', 
                   'Blue'
                 ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Int-Port.jpg",
                'IsLegacy'                    => false,
                'Styles' => [
                   'CIC',
                   'MiniCanal',
                   'Canal',
                   'HalfShell',
                   'FullShell',
                ],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [59, 57, 56, 55, 57, 63, 49, 51, 23, 18],
                'Options' => [ 
                   'Telecoil',
                   'AutoTelecoil',
                   'PlusPower',
                   'Super60',
                   'Super70',
                   'WaxSystem', 
                   "HF3/NWK",
                ],
             ],
             
             //  Product Intuition 2FC
            'prod_Intuition2FC' => [
                'Name'                        => "Intuir 2FC",
                'ProductID'                   => 'prod_Intuition2FC',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "Spin",
                'CircuitID'                   => 'Spin',
                'TechnologyLevel'             => 'Entry2',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                    => ['Custom', 'BTE'],
                'HousingIDs'                  => ['Custom_Shell', 'BTE_Int'],
                'HousingFilename'             => "images/icons/icon-housing-custom-bte.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown',  
                   'LightBrown',  
                   'Tan', 
                   'Red', 
                   'Blue',
                ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Int-Port.jpg",
                'IsLegacy'                    => true,
                'Styles' => [
                   'CIC',
                   'MiniCIC',
                   'MiniCanal',
                   'Canal',
                   'HalfShell',
                   'FullShell',
                   'BTE',
                ],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [59, 57, 56, 55, 57, 63, 49, 51, 23, 18],
                'Options' => [
                   'Telecoil',
                   'AutoTelecoil',
                   'PlusPower',
                   'Super60',
                   'Super70',
                   'WaxSystem',
                   "HF3/NWK",
                ],  
            ],
            
            //  Product Intuition 2FC+
            'prod_Intuition2FCPlus' => [
                'Name'                        => "Intuir 2FC+",
                'ProductID'                   => 'prod_Intuition2FCPlus',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "SpinNR",
                'CircuitID'                   => 'SpinNR',
                'TechnologyLevel'             => 'Entry2',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                    => 'Custom',
                'HousingIDs'                  => 'Custom_Shell',
                'HousingFilename'             => "images/icons/icon-housing-custom.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown',  
                   'LightBrown',  
                   'Tan', 
                   'Red', 
                   'Blue' 
                 ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-Custom_Shell-Custom.jpg",
                'IsLegacy'                    => false,
                'Styles' => [
                    'CIC',
                    'MiniCIC',
                    'MiniCanal',
                    'Canal',
                    'HalfShell',
                    'FullShell',
                ],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [59, 57, 56, 55, 57, 63, 49, 51, 23, 18],
                'Options' => [ 
                    'Telecoil',
                    'AutoTelecoil',
                    'PlusPower',
                    'Super60',
                    'Super70',
                    'WaxSystem',
                    "HF3/NWK",
                ],  
            ],
            
            //  Product Intuition 2ER
            'prod_Intuition2ER' => [
                'Name'                        => "Intuir 2ER",
                'ProductID'                   => 'prod_Intuition2ER',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "SpinNR",
                'CircuitID'                   => 'SpinNR',
                'TechnologyLevel'             => 'Mid',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                    => 'Custom',
                'HousingIDs'                  => 'Custom_Shell',
                'HousingFilename'             => "images/icons/icon-housing-custom.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown',  
                   'LightBrown',  
                   'Tan', 
                   'Red', 
                   'Blue'
                 ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-Custom_Shell-Custom.jpg",
                'IsLegacy'                    => false,
                'Styles' => [
                   'CIC',
                   'MiniCIC',
                   'MiniCanal',
                   'Canal',
                   'HalfShell',
                   'FullShell',
                ],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [59, 57, 56, 55, 57, 63, 49, 51, 23, 18],
                'Options' => [ 
                    'Telecoil',
                    'AutoTelecoil',
                    'PlusPower',
                    'Super60',
                    'Super70',
                    'WaxSystem',
                    "HF3/NWK",
                ],  
            ],
            
            //  Product Intuition 4D
            'prod_Intuition4D' => [
                'Name'                       => "Intuir 4D",
                'ProductID'                   => 'prod_Intuition4D',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "DigitalOne4NRPlus",
                'CircuitID'                   => 'DigitalOne4NRPlus',
                'TechnologyLevel'             => 'Mid2',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                   => ['Custom', 'BTE'],
                'HousingIDs'                  => ['Custom_Shell', 'BTE_Int'],
                'HousingFilename'             => "images/icons/icon-housing-bte-int.png",
                'HousingColor'                => ['Beige'],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Int-Port.jpg",
                'IsLegacy'                    => true,
                'Styles'          => ['BTE'],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [73, 79, 80, 83, 89, 81, 82, 81, 54, 44],
                'Options'         => [],
            ],
            
            //  Product Intuition 4
            'prod_Intuition4' => [
                'Name'                        => "Intuir 4",
                'ProductID'                   => 'prod_Intuition4',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "DigitalOne4NRPlus",
                'CircuitID'                   => 'DigitalOne4NRPlus',
                'TechnologyLevel'             => 'Mid',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                   => ['Custom', 'BTE'],
                'HousingIDs'                  => ['Custom_Shell', 'BTE_Int'],
                'HousingFilename'             => "images/icons/icon-housing-custom-bte.png",
                'HousingColor'                => ['Beige', 
                     'Brown',  
                     'LightBrown',  
                     'Tan', 
                     'Red', 
                     'Blue',
                 ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Int-Port.jpg",
                'IsLegacy'                    => true,
                'Styles' => [
                   'CIC',
                   'MiniCIC',
                   'MiniCanal',
                   'Canal',
                   'HalfShell',
                   'FullShell',
                   'BTE',
                ],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [73, 79, 80, 83, 89, 81, 82, 81, 54, 44],
                'Options' => [
                   'Telecoil',
                   'PlusPower',
                   'Super60',
                   'Super70',
                   'WaxSystem',
                   "HF3/NWK"
                ],  
            ],
            
            //  Product Intuition 4+
            'prod_Intuition4Plus' => [
                'Name'                        => "Intuir 4+",
                'ProductID'                   => 'prod_Intuition4Plus',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "InTune",
                'CircuitID'                   => 'InTune',
                'TechnologyLevel'             => 'Mid',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                   => ['Custom', 'BTE'],
                'HousingIDs'                  => ['Custom_Shell', 'BTE_Int'],
                'HousingFilename'             => "images/icons/icon-housing-custom.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown',  
                   'LightBrown',  
                   'Tan', 
                   'Red', 
                   'Blue',
                 ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Int-Port.jpg",
                'IsLegacy'                    => false,
                'Styles' => [
                   'CIC',
                   'MiniCIC',
                   'MiniCanal',
                   'Canal',
                   'HalfShell',
                   'FullShell',
                ],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [73, 79, 80, 83, 89, 81, 82, 81, 54, 44],
                'Options' => [ 
                   'Telecoil',
                   'AutoTelecoil',
                   'PlusPower',
                   'Super60',
                   'Super70',
                   'WaxSystem',
                   "HF3/NWK"
                ],  
            ],
            
            //  Product Intuition 4AD
            'prod_Intuition4AD' => [
                'Name'                        => "Intuir 4AD",
                'ProductID'                   => 'prod_Intuition4AD',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "InTune",
                'CircuitID'                   => 'InTune',
                'TechnologyLevel'             => 'Mid2',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                   => ['Custom', 'BTE'],
                'HousingIDs'                  => ['Custom_Shell', 'BTE_Int'],
                'HousingFilename'             => "images/icons/icon-housing-custom-hs-fss-bte.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown',  
                   'LightBrown',  
                   'Tan', 
                   'Red', 
                   'Blue',
                 ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Int-Port.jpg",
                'IsLegacy'                    => false,
                'Styles' => [
                   'HalfShell',
                   'FullShell',
                   'BTE',
                ],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [73, 79, 80, 83, 89, 81, 82, 81, 54, 44],
                'Options' => [ 
                   'Telecoil',
                   'AutoTelecoil',
                   'PlusPower',
                   'Super60',
                   'Super70',
                   'WaxSystem',
                   "HF3/NWK"
                ],  
            ],
            
            //  Product Intuition 6
            'prod_Intuition6' => [
                'Name'                          => "Intuir 6",
                'ProductID'                     => 'prod_Intuition6',
                'ProductFamily'                 => "Intuir",
                'CircuitFamily'                 => "Audion6",
                'CircuitID'                     => 'Audion6',
                'TechnologyLevel'               => 'Premium',
                'BatterySize'                   => 'Multiple',
                'Channels'                      => 6,
                'AutoEnvironmentSwitching'      => 0,
                'AdaptiveDirectionalChannels'   => 1,
                'GainBands'                     => 12,
                'NoiseReduction'                => true,
                'BluetoothCompatible'           => false,
                'AudioLoopSystemCompatible'     => false,
                'FMLoopSystemCompatible'        => true,
                'PhoneLoopSystemCompatible'     => true,
                'Telecoil'                      => 'Optional',
                'AutoTelecoil'                  => 'Optional',
                'AdaptiveFeedbackCanceller'     => true,
                'DataloggerType'                => 'None',
                'WindManager'                   => false,
                'TinnitusNoiseGenerator'        => false,
                'ManualPrograms'                => 4,
                'Housing'                       => 'Custom',
                'Housings'                      => ['Custom'],
                'HousingIDs'                    => ['Custom_Shell'],
                'HousingFilename'               => "images/icons/icon-housing-custom.png",
                'HousingColor'                  => [
                   'Beige', 
                   'Brown',  
                   'LightBrown',  
                   'Tan', 
                   'Red', 
                   'Blue'
                 ],
                'ProgrammerCable'               => 'Gray_4x',
                'ConnectivityFilename'          => "images/accessories/housing-conn-Custom_Shell-Custom.jpg",
                'IsLegacy'                      => false,
                'Styles' => [
                   'CIC',
                   'MiniCIC',
                   'MiniCanal',
                   'Canal',
                   'HalfShell',
                   'FullShell',
                ],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [69, 69, 68, 67, 70, 78, 64, 69, 36, 27],
                'Options' => [ 
                   'AdaptiveDirectionality',
                   'Telecoil',
                   'AutoTelecoil',
                   'PlusPower',
                   'Super60',
                   'Super70',
                   'WaxSystem',
                   "HF3/NWK"
                ],  
            ], 
            
            //  Product Intuition 12
            'prod_Intuition12' => [
                'Name'                        => "Intuir 12",
                'ProductID'                   => 'prod_Intuition12',
                'ProductFamily'               => "Intuir",
                'CircuitFamily'               => "Ethos",
                'CircuitID'                   => 'Ethos',
                'TechnologyLevel'             => 'Premium',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 8,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'Custom',
                'Housings'                    => 'Custom',
                'HousingIDs'                  => 'Custom_Shell',
                'HousingFilename'             => "images/icons/icon-housing-custom.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown', 
                   'LightBrown', 
                   'Tan', 
                   'Red', 
                   'Blue'
                ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-Custom_Shell-Custom.jpg",
                'IsLegacy'                    => false,
                'Styles' => [
                   'CIC',
                   'MiniCIC',
                   'MiniCanal',
                   'Canal',
                   'HalfShell',
                   'FullShell',
                ],
                'FittingRangeMin' => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax' => [69, 69, 68, 67, 70, 78, 64, 69, 36, 27],
                'Options' => [ 
                   'AdaptiveDirectionality',
                   'Telecoil',
                   'AutoTelecoil',
                   'PlusPower',
                   'Super60',
                   'Super70',
                   'WaxSystem',
                   "HF3/NWK"
                ],  
            ], 
            
            //  Product IRIC 2
            'prod_IntuitionRIC2' => [
                'Name'                        => "Fino 2",
                'ProductID'                   => 'prod_IntuitionRIC2',
                'ProductFamily'               => "Fino",
                'CircuitFamily'               => "SpinNR",
                'CircuitID'                   => 'SpinNR',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'AutoTelecoil'                => 'Unavailable',
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'MiniBTE',
                'Housings'                   => ['MiniBTE'],
                'HousingIDs'                  => ['RIC_v3'],
                'HousingFilename'             => "images/icons/icon-housing-iric.png",
                'HousingColor'                => ['Beige', 'Silver'],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-RIC_v3-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['RIC'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [43, 42, 41, 41, 39, 39, 46, 47, 33, 2],
                'Options'          => ['Receiver: HI-Def, Wideband, Power, HighPower'],  
            ], 
            
            //  Product IRIC 4
            'prod_IntuitionRIC4' => [
                'Name'                        => "Fino 4",
                'ProductID'                   => 'prod_IntuitionRIC4',
                'ProductFamily'               => "Fino",
                'CircuitFamily'               => "InTune",
                'CircuitID'                   => 'InTune',
                'TechnologyLevel'             => 'Mid',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'AutoTelecoil'                => 'Unavailable',
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'MiniBTE',
                'Housings'                    => ['MiniBTE'],
                'HousingIDs'                  => ['RIC_v3'],
                'HousingFilename'             => "images/icons/icon-housing-iric.png",
                'HousingColor'                => ['Beige', 'Silver'],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-RIC_v3-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['RIC'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [56, 62, 61, 61, 60, 59, 66, 68, 53, 3],
                'Options'          => ['Receiver: HI-Def, Wideband, Power, HighPower'], 
            ],
            
            //  Product IRIC 6
            'prod_IntuitionRIC6' => [
                'Name'                        => "Fino 6",
                'ProductID'                   => 'prod_IntuitionRIC6',
                'ProductFamily'               => "Fino",
                'CircuitFamily'               => "Audion6",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Mid',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'AutoTelecoil'                => 'Unavailable',
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'MiniBTE',
                'Housings'                    => ['MiniBTE'],
                'HousingIDs'                  => ['RIC_v3'],
                'HousingFilename'             => "images/icons/icon-housing-iric.png",
                'HousingColor'                => ['Beige', 'Silver'],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-RIC_v3-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['RIC'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [56, 62, 61, 61, 60, 59, 66, 68, 53, 3],
                'Options'          => ['Receiver: HI-Def, Wideband, Power, HighPower'], 
             ],
             
             //  Product IRIC 12
            'prod_IntuitionRIC12' => [
                'Name'                        => "Fino 12",
                'ProductID'                   => 'prod_IntuitionRIC12',
                'ProductFamily'               => "Fino",
                'CircuitFamily'               => "Ethos",
                'CircuitID'                   => 'Ethos',
                'TechnologyLevel'             => 'Premium',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 8,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'AutoTelecoil'                => 'Unavailable',
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'MiniBTE',
                'Housings'                    => ['MiniBTE'],
                'HousingIDs'                  => ['RIC_v3'],
                'HousingFilename'             => "images/icons/icon-housing-iric.png",
                'HousingColor'                => ['Beige', 'Silver'],
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-RIC_v3-Flexstrip.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['RIC'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [54, 56, 55, 55, 53, 53, 60, 62, 47, 2],
                'Options'          => ['Receiver: Wideband, Power, HighPower'], 
            ],
            
            //  Product nVe AD
            'prod_nVeAD' => [ 
                'Name'                        => "Fino AD (1st gen)",
                'ProductID'                   => 'prod_nVeAD',
                'ProductFamily'               => "Fino (1st gen)",
                'CircuitFamily'               => "InTune",
                'CircuitID'                   => 'InTune',
                'TechnologyLevel'             => 'Mid2',
                'BatterySize'                 => 'Size312Brown',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => false,
                'AutoTelecoil'                => 'Unavailable',
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                    => ['BTE'],
                'HousingIDs'                  => ['RIC_v1'],
                'HousingFilename'             => "images/icons/icon-housing-iric.png",
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-RIC_v1-Flexstrip.jpg",
                'IsLegacy'                    => true,
                'IsStockProduct'              => true,
                'SupportedVCTypes'  => ['None'],
                'Styles'            => ['RIC'],
                'FittingRangeMin'   => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'   => [ 56, 62, 61, 61, 60, 59, 66, 68, 53, 3 ],
                'Options'           => ['Receiver: Standard'],
             ],
             
             //  Product Octane T
            'prod_OctaneT' => [
                'Name'                        => "Boost T",
                'ProductID'                   => 'prod_OctaneT',
                'ProductFamily'               => "Boost",
                'CircuitFamily'               => "Audion 4",
                'CircuitID'                   => 'Audion4',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size675Blue',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                    => ['BTE'],
                'HousingIDs'                  => ['BTE_SuperPower'],
                'HousingFilename'             => "images/icons/icon-housing-octane.png",
                'HousingColor'                => ['Beige', 'Gray',],
                'ProgrammerCable'             => 'Black_5x_StraightConnector',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_SuperPower-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Digital',],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 50, 50, 50, 50, 50, 50, 50, 50, 50, 50 ],
                'FittingRangeMax'  => [ 120, 120, 120, 120, 120, 120, 120, 120, 120, 120 ],
                'Options'          => ['AutoTelecoil']
            ],
            
            //  Product Octane 4
            'prod_Octane4' => [
                'Name'                        => "Boost 4",
                'ProductID'                   => 'prod_Octane4',
                'ProductFamily'               => "Boost",
                'CircuitFamily'               => "Audion 4",
                'CircuitID'                   => 'Audion4',
                'TechnologyLevel'             => 'Entry2',
                'BatterySize'                 => 'Size675Blue',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                    => ['BTE'],
                'HousingIDs'                  => ['BTE_SuperPower'],
                'HousingFilename'             => "images/icons/icon-housing-octane.png",
                'HousingColor'                => ['Beige', 'Gray',],
                'ProgrammerCable'             => 'Black_5x_StraightConnector',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_SuperPower-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Digital'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 50, 50, 50, 50, 50, 50, 50, 50, 50, 50 ],
                'FittingRangeMax'  => [ 120, 120, 120, 120, 120, 120, 120, 120, 120, 120 ],
                'Options'          => ['AutoTelecoil'],
            ],
            
            //  Product Octane 6
            'prod_Octane6' => [ 
                'Name'                        => "Boost 6",
                'ProductID'                   => 'prod_Octane6',
                'CircuitFamily'               => "Audion 6",
                'ProductFamily'               => "Boost",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Mid',
                'BatterySize'                 => 'Size675Blue',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                   => ['BTE'],
                'HousingIDs'                  => ['BTE_SuperPower'],
                'HousingFilename'             => "images/icons/icon-housing-octane.png",
                'HousingColor'                => ['Beige', 'Gray',],
                'ProgrammerCable'             => 'Black_5x_StraightConnector',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_SuperPower-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Digital'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 50, 50, 50, 50, 50, 50, 50, 50, 50, 50 ],
                'FittingRangeMax'  => [ 120, 120, 120, 120, 120, 120, 120, 120, 120, 120 ],
                'Options'          => ['AutoTelecoil'],
            ],
            
            //  Product Octane 12
            'prod_Octane8' => [
                'Name'                        => "Boost 12",
                'ProductID'                   => 'prod_Octane8',
                'ProductFamily'               => "Boost",
                'CircuitFamily'               => "Audion 8",
                'CircuitID'                   => 'Audion8',
                'TechnologyLevel'             => 'Premium',
                'BatterySize'                 => 'Size675Blue',
                'Channels'                    => 8,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Optional',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                    => ['BTE'],
                'HousingIDs'                  => ['BTE_SuperPower'],
                'HousingFilename'             => "images/icons/icon-housing-octane.png",
                'HousingColor'                => ['Beige', 'Gray'],
                'ProgrammerCable'             => 'Black_5x_StraightConnector',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_SuperPower-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Digital'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 50, 50, 50, 50, 50, 50, 50, 50, 50, 50 ],
                'FittingRangeMax'  => [ 120, 120, 120, 120, 120, 120, 120, 120, 120, 120 ],
                'Options'          => ['AutoTelecoil'],
            ],
            
            //  Product Sparo 2
            'prod_Sparo2' => [
                'Name'                        => "Briza 2",
                'ProductID'                   => 'prod_Sparo2',
                'ProductFamily'               => "Briza",
                'CircuitFamily'               => "Spin",
                'CircuitID'                   => 'Spin',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size10AYellow',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'HSP',
                'Housings'                    => ['HSP'],
                'HousingIDs'                  => ['OTE_v1'],
                'HousingFilename'             => "images/icons/icon-housing-sparo-open.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown', 
                   'Mocha', 
                   'Charcoal', 
                   'Gray', 
                   'Silver',
                ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v1-Flexstrip.jpg",
                'IsLegacy'                    => true,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [41, 41, 41, 43, 52, 45, 42, 39, 21, 2],
                'Options'          => ['Telecoil', 'BTEEarhook'],              
            ],
            
            //  Product Sparo 2+
            'prod_Sparo2Plus' => [
                'Name'                        => "Briza 2+",
                'ProductID'                   => 'prod_Sparo2Plus',
                'ProductFamily'               => "Briza",
                'CircuitFamily'               => "SpinNR",
                'CircuitID'                   => 'SpinNR',
                'TechnologyLevel'             => 'Entry2',
                'BatterySize'                 => 'Size10AYellow',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'HSP',
                'Housings'                    => ['HSP'],
                'HousingIDs'                  => ['OTE_v1'],
                'HousingFilename'             => "images/icons/icon-housing-sparo-open.png",
                'HousingColor'                => [
                   'Beige', 
                     'Brown', 
                     'Mocha', 
                     'Charcoal', 
                     'Gray', 
                     'Silver'
                 ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v1-Flexstrip.jpg",
                'IsLegacy'                    => true,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [41, 41, 41, 43, 52, 45, 42, 39, 21, 2],
                'Options'          => ['Telecoil', 'BTEEarhook',],
            ],

            //  Product Sparo 2ER
            'prod_Sparo2ER' => [
                'Name'                        => "Briza 2ER",
                'ProductID'                   => 'prod_Sparo2ER',
                'ProductFamily'               => "Briza",
                'CircuitFamily'               => "SpinNR",
                'CircuitID'                   => 'SpinNR',
                'TechnologyLevel'             => 'Mid',
                'BatterySize'                 => 'Size10AYellow',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'HSP',
                'Housings'                    => ['HSP'],
                'HousingIDs'                  => ['OTE_v1'],
                'HousingFilename'             => "images/icons/icon-housing-sparo-open.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown', 
                   'Mocha', 
                   'Charcoal',
                   'Gray', 
                   'Silver',
                ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v1-Flexstrip.jpg",
                'IsLegacy'                    => true,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [41, 41, 41, 43, 52, 45, 42, 39, 21, 2],
                'Options'          => ['Telecoil', 'BTEEarhook'],              
            ],
            
            //  Product Sparo 4
            'prod_Sparo4' => [
                'Name'                        => "Briza",
                'ProductID'                   => 'prod_Sparo4',
                'ProductFamily'               => "Briza",
                'CircuitFamily'               => "DigitalOne4NR",
                'CircuitID'                   => 'DigitalOne4NRPlus',
                'TechnologyLevel'             => 'Mid',
                'BatterySize'                 => 'Size10AYellow',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'HSP',
                'Housings'                    => ['HSP'],
                'HousingIDs'                  => ['OTE_v1'],
                'HousingFilename'             => "images/icons/icon-housing-sparo-open.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown', 
                   'Mocha', 
                   'Charcoal',
                   'Gray', 
                   'Silver',
                ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v1-Flexstrip.jpg",
                'IsLegacy'                    => true,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [54, 61, 61, 63, 73, 65, 62, 60, 41, 3],
                'Options'          => ['Telecoil', 'BTEEarhook'],              
            ],
            
            //  Product Sparo AD
            'prod_SparoAD' => [
                'Name'                        => "Briza AD",
                'ProductID'                   => 'prod_SparoAD',
                'ProductFamily'               => "Briza",
                'CircuitFamily'               => "InTune",
                'CircuitID'                   => 'InTune',
                'TechnologyLevel'             => 'Mid2',
                'BatterySize'                 => 'Size10AYellow',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'HSP',
                'Housings'                    => ['HSP'],
                'HousingIDs'                  => ['OTE_v1'],
                'HousingFilename'             => "images/icons/icon-housing-sparo-open.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown', 
                   'Mocha', 
                   'Charcoal', 
                   'Gray', 
                   'Silver',
                ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v1-Flexstrip.jpg",
                'IsLegacy'                    => true,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [54, 61, 61, 63, 73, 65, 62, 60, 41, 3],
                'Options'          => ['Telecoil', 'BTEEarhook'],              
            ], 
            
            //  Product Sparo 12
            'prod_Sparo12' => [
                'Name'                        => "Briza 12",
                'ProductID'                   => 'prod_Sparo12',
                'ProductFamily'               => "Briza",
                'CircuitFamily'               => "Ethos",
                'CircuitID'                   => 'Ethos',
                'TechnologyLevel'             => 'Premium',
                'BatterySize'                 => 'Size10AYellow',
                'Channels'                    => 8,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'NoSelfLearning',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => true,
                'ManualPrograms'              => 4,
                'Housing'                     => 'HSP',
                'Housings'                    => ['HSP'],
                'HousingIDs'                  => ['OTE_v1'],
                'HousingFilename'             => "images/icons/icon-housing-sparo-open.png",
                'HousingColor'                => [
                   'Beige', 
                   'Brown', 
                   'Mocha', 
                   'Charcoal', 
                   'Gray', 
                   'Silver',
                 ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-OTE_v1-Flexstrip.jpg",
                'IsLegacy'                    => true,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['None'],
                'Styles'           => ['OTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [52, 55, 55, 57, 67, 59, 56, 56, 34, 2],
                'Options'          => ['Telecoil', 'BTEEarhook'],
            ],
            
            //  Product Simplex 2P+
            'prod_Simplex' => [
                'Name'                        => "Ligero 2P+",
                'ProductID'                   => 'prod_Simplex',
                'ProductFamily'               => "Ligero",
                'CircuitFamily'               => "Essential",
                'CircuitID'                   => 'Essential',
                'TechnologyLevel'             => 'Entry2',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => false,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                    => ['BTE'],
                'HousingIDs'                  => ['BTE_Classic'],
                'HousingFilename'             => "images/icons/icon-housing-bte-classic.png",
                'HousingColor'                => ['Beige'],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Classic-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Analog'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 59, 57, 56, 55, 57, 63, 49, 51, 23, 18 ],
                'Options'          => ['Telecoil'],
             ],
             
             //  Product Simplex 2P BTE
            'prod_Simplex2PBTE' => [ 
                'Name'                       => "Ligero 2P BTE",
                'ProductID'                   => 'prod_Simplex2PBTE',
                'ProductFamily'               => "Ligero",
                'CircuitFamily'               => "DigitalOne2CT",
                'CircuitID'                   => 'DigitalOne2CT',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Multiple',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 10,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Optional',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => false,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                    => ['BTE'],
                'HousingIDs'                  => ['BTE_Classic'],
                'HousingFilename'             => "images/icons/icon-housing-bte-classic.png",
                'HousingColor'                => ['Beige'],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Classic-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Analog'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
                'FittingRangeMax'  => [ 59, 57, 56, 55, 57, 63, 49, 51, 23, 18 ],
                'Options'          => ['Telecoil'],
            ],
            
            //  Product BTE 478P+
            'prod_BTE478PPlus' => [ 
                'Name'                        => "BTE 278P+",
                'ProductID'                   => 'prod_BTE478PPlus',
                'ProductFamily'               => "BTE",
                'CircuitFamily'               => "Essential",
                'CircuitID'                   => 'Essential',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size675Blue',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => true,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => false,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                   => ['BTE'],
                'HousingIDs'                  => ['BTE_Classic'],
                'HousingFilename'             => "images/icons/icon-housing-bte-classic.png",
                'HousingColor'                => ['Beige'],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Classic-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Analog'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 15, 15, 15, 40, 40, 40, 40, 40, 40, 40 ],
                'FittingRangeMax'  => [ 100, 100, 100, 100, 100, 100, 100, 100, 100, 100 ],
                'Options'          => [],
             ],
             
             //  Product BTE 675DP+
            'prod_BTE675DPPlus' => [
                'Name'                        => "BTE D60P+",
                'IsVisible'                   => true, //(Country !=> "USA" || PermissionTypeList.Contains(TAppPermissionType.RegionOverride)),
                'ProductFamily'               => "BTE",
                'ProductID'                   => 'prod_BTE675DPPlus',
                'CircuitFamily'               => "Essential",
                'CircuitID'                   => 'Essential',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size675Blue',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => false,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                   => ['BTE'],
                'HousingIDs'                  => ['BTE_Classic'],
                'HousingFilename'             => "images/icons/icon-housing-bte-classic.png",
                'HousingColor'                => ['Beige' ],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Classic-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Analog'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 45, 45, 45, 45, 45, 45 ],
                'FittingRangeMax'  => [ 90, 90, 90, 90, 90, 90, 90, 90, 90, 90 ],
                'Options'          => [],
             ],
             
             //  Product BTE 675DP-2
            'prod_BTE675DP2' => [
                'Name'                        => "BTE D60P-2",
                'IsVisible'                   => false,
                'ProductFamily'               => "BTE",
                'ProductID'                   => 'prod_BTE675DP2',
                'CircuitFamily'               => "Essential",
                'CircuitID'                   => 'Essential',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size675Blue',
                'Channels'                    => 2,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => false,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => false,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => false,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                   => ['BTE'],
                'HousingIDs'                  => ['BTE_Classic'],
                'HousingFilename'             => "images/icons/icon-housing-bte-classic.png",
                'HousingColor'                => ['Beige'],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Classic-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Analog'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 45, 45, 45, 45, 45, 45 ],
                'FittingRangeMax'  => [ 90, 90, 90, 90, 90, 90, 90, 90, 90, 90 ],
                'Options'          => [],
             ],
             
             //  Product BTE D4P
            'prod_BTED4P' => [ 
                'Name'                       => "BTE D4P",
                'IsVisible'                   => true, //(Country !=> "USA" || PermissionTypeList.Contains(TAppPermissionType.RegionOverride)),
                'ProductID'                   => 'prod_BTED4P',
                'ProductFamily'               => "BTE",
                'CircuitFamily'               => "Audion4",
                'CircuitID'                   => 'Audion4',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size13Orange',
                'Channels'                    => 4,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                    => ['BTE' ],
                'HousingIDs'                  => ['BTE_Classic'],
                'HousingFilename'             => "images/icons/icon-housing-bte-classic.png",
                'HousingColor'                => ['Beige'],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Classic-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Analog'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 15, 40, 40, 40, 40, 40 ],
                'FittingRangeMax'  => [ 80, 80, 80, 80, 80, 80, 80, 80, 80, 80 ],
                'Options'          => [],
             ],
             
             //  Product BTE D6HP
            'prod_BTED6HP' => [ 
                'Name'                        => "BTE D70HP",
                'ProductID'                   => 'prod_BTED6HP',
                'ProductFamily'               => "BTE",
                'CircuitFamily'               => "Audion6",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size13Orange',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 0,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                    => ['BTE'],
                'HousingIDs'                  => ['BTE_Classic'],
                'HousingFilename'             => "images/icons/icon-housing-bte-classic.png",
                'HousingColor'                => ['Beige'],
                'ProgrammerCable'             => 'Gray_4x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Classic-Port.jpg",
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'SupportedVCTypes' => ['Analog'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 15, 40, 40, 40, 40, 40 ],
                'FittingRangeMax'  => [ 80, 80, 80, 80, 80, 80, 80, 80, 80, 80 ],
                'Options'          => [],
             ],
             
             //  Product BTE 6AD
            'prod_BTE6AD' => [
                'Name'                        => "BTE 55AD",
                'ProductID'                   => 'prod_BTE6AD',
                'ProductFamily'               => "BTE",
                'CircuitFamily'               => "Audion6",
                'CircuitID'                   => 'Audion6',
                'TechnologyLevel'             => 'Entry',
                'BatterySize'                 => 'Size675Blue',
                'Channels'                    => 6,
                'AutoEnvironmentSwitching'    => 0,
                'AdaptiveDirectionalChannels' => 1,
                'NumberOfMicrophones'         => 2,
                'GainBands'                   => 12,
                'NoiseReduction'              => true,
                'BluetoothCompatible'         => false,
                'AudioLoopSystemCompatible'   => false,
                'FMLoopSystemCompatible'      => false,
                'PhoneLoopSystemCompatible'   => true,
                'Telecoil'                    => 'Standard',
                'AutoTelecoil'                => 'Unavailable',
                'AdaptiveFeedbackCanceller'   => true,
                'DataloggerType'              => 'None',
                'WindManager'                 => false,
                'TinnitusNoiseGenerator'      => false,
                'ManualPrograms'              => 4,
                'Housing'                     => 'BTE',
                'Housings'                    => ['BTE'],
                'HousingIDs'                  => ['BTE_Euro'],
                'HousingFilename'             => "images/icons/icon-housing-bte-euro.png",
                'HousingColor'                => ['Beige'],
                'IsLegacy'                    => false,
                'IsStockProduct'              => true,
                'ProgrammerCable'             => 'Black_5x',
                'ConnectivityFilename'        => "images/accessories/housing-conn-BTE_Euro-Flexstrip.jpg",
                'SupportedVCTypes' => ['Analog'],
                'Styles'           => ['BTE'],
                'FittingRangeMin'  => [ 2, 2, 2, 2, 15, 40, 40, 40, 40, 40 ],
                'FittingRangeMax'  => [ 80, 80, 80, 80, 80, 80, 80, 80, 80, 80 ],
                'Options'          => [],
             ],
        ];
        
        return $products;
    }
    
}


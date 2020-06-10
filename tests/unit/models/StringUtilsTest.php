<?php
namespace test\models;
use app\models\StringUtils;

class StringUtilsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testStringTrimming()
    {
        // Left trim
        expect(StringUtils::ltrim_string("  "))->equals("");
        expect(StringUtils::ltrim_string(""))->equals("");
        expect(StringUtils::ltrim_string("123", "123"))->equals("");
        expect(StringUtils::ltrim_string("", "123"))->equals("");
        expect(StringUtils::ltrim_string("  Hello"))->equals("Hello");
        expect(StringUtils::ltrim_string("123Hello", "123"))->equals("Hello");
        
        // Right trim
        expect(StringUtils::rtrim_string("  "))->equals("");
        expect(StringUtils::rtrim_string(""))->equals("");
        expect(StringUtils::rtrim_string("123", "123"))->equals("");
        expect(StringUtils::rtrim_string("", "123"))->equals("");
        expect(StringUtils::rtrim_string("Hello  "))->equals("Hello");
        expect(StringUtils::rtrim_string("Hello123", "123"))->equals("Hello");
    }
    
    public function testStringCleaning()
    {
        // Commas
        expect(StringUtils::stripExtraChars(",Hello,,,,,"))->equals("Hello");
        expect(StringUtils::stripExtraChars(",Hello,,,,"))->equals("Hello");
        expect(StringUtils::stripExtraChars(",Hello,,,"))->equals("Hello");
        expect(StringUtils::stripExtraChars(",Hello,,"))->equals("Hello");
        expect(StringUtils::stripExtraChars(",Hello,"))->equals("Hello");
        expect(StringUtils::stripExtraChars(",Red,,,,Green,,Blue,Yellow,"))->equals("Red,Green,Blue,Yellow");
        
        // Spaces
        expect(StringUtils::stripSpaces("  H e  l l  o  ", "123"))->equals("Hello");
        expect(StringUtils::stripSpaces("   "))->equals("");
        expect(StringUtils::stripSpaces(""))->equals("");
        
        // Newlines
        expect(StringUtils::stripNewLineReturn("Hello\n\n\n"))->equals("Hello");
        expect(StringUtils::stripNewLineReturn("Hello\n\n"))->equals("Hello");
        expect(StringUtils::stripNewLineReturn("Hello\n"))->equals("Hello");
        expect(StringUtils::stripNewLineReturn("H\ne\nl\nl\no\n"))->equals("Hello");
        expect(StringUtils::stripNewLineReturn("H\re\r\nl\rl\n\ro\r"))->equals("Hello");
        
        // Non-alphanumeric
        expect(StringUtils::filterAlphaNumCharsOnly("H\re\r\nl\rl\n\ro\r\t\0 123"))->equals("Hello123");
        
        // Non-alpha
        expect(StringUtils::filterAlphaCharsOnly("H\re\r\nl\rl\n\ro\r\t\0 123"))->equals("Hello");
    }
    
    public function testStringTransformation()
    {
        // Spaces
        expect(StringUtils::nameize(""))->equals("");
        
        // Delimiter: Mc
        expect(StringUtils::nameize("Steve McEwen"))->equals("Steve McEwen");
        expect(StringUtils::nameize("steve mcewen"))->equals("Steve McEwen");
        //expect(StringUtils::nameize("STEVE MCEWEN"))->notEquals("Steve McEwen");  // Does not transform all caps
        expect(StringUtils::nameize("STEVE MCEWEN"))->equals("Steve McEwen");
        
        // Delimiter: Dash
        expect(StringUtils::nameize("maria perez-morales"))->equals("Maria Perez-Morales");
        
        // Delimiter: Apostrophe
        expect(StringUtils::nameize("Mike O'connell"))->equals("Mike O'Connell");
        expect(StringUtils::nameize("mike o'connell"))->notEquals("Mike O'connell");
        expect(StringUtils::nameize("mike o'connell"))->notEquals("mike o'connell");
        expect(StringUtils::nameize("mike o'connell"))->notEquals("MIKE O'CONNELL");
        
        // Roman Numerals
        expect(StringUtils::nameize("antonio i"))->equals("Antonio I");
        expect(StringUtils::nameize("antonio ii"))->equals("Antonio II");
        expect(StringUtils::nameize("antonio iii"))->equals("Antonio III");
        expect(StringUtils::nameize("antonio iv"))->equals("Antonio IV");
        expect(StringUtils::nameize("antonio v"))->equals("Antonio V");
        expect(StringUtils::nameize("antonio vi"))->equals("Antonio VI");
        expect(StringUtils::nameize("antonio vii"))->equals("Antonio VII");
        expect(StringUtils::nameize("antonio viii"))->equals("Antonio VIII");
        expect(StringUtils::nameize("antonio ix"))->equals("Antonio IX");
        expect(StringUtils::nameize("antonio x"))->equals("Antonio X");
        
        // Prepositions
        expect(StringUtils::nameize("johann wolfgang von goethe"))->equals("Johann Wolfgang von Goethe");
        expect(StringUtils::nameize("jean de la fontaine"))->equals("Jean de La Fontaine");
        expect(StringUtils::nameize("maria del pilar"))->equals("Maria del Pilar");
        expect(StringUtils::nameize("jean du merchant"))->equals("Jean du Merchant");
        
        // Uppercase first
        expect(StringUtils::ucname("jean du merchant"))->equals("Jean Du Merchant");
        expect(StringUtils::ucname("JEAN DU MERCHANT"))->equals("Jean Du Merchant");
        
        // Unicode
        expect(StringUtils::nameize("maría pérez-françois"))->equals("María Pérez-François");
        expect(StringUtils::ucname("maría pérez-françois"))->equals("María Pérez-François");
    }
}
<?php

use yii\db\Schema;
use yii\db\Migration;

class m180507_120000_table_content_auditiva extends Migration
{
    //public function init()
    //{
    //    $this->db = 'db2';
    //    parent::init();
    //}
    
    // # Run specific migration:
    // $ yii migrate/to m180507_120000_table_content_auditiva     # perform migration
    // $ yii migrate/down 1                                       # revert the most recently applied migration
    public function up()
    {
        $this->addDataTableContent();
        $this->addDataTableDistributor();
        $this->addDataTableTestimonial();
        $this->addDataTableUser();
    }

    public function down()
    {
        //echo "m180507_120000_table_content_auditiva cannot be reverted.\n";
        //return false;
    }
    
    public function addDataTableContent()
    {
        // table name, column names, column values
        
        $this->insert('{{%content}}', array('id' => '1','title' => 'Boost ® Family of Super Power BTEs Now Available','category_id' => '4','tags' => '','intro_text' => '<p>Auditiva&reg; Introduces the Boost&reg; Family of SUPER POWER BTEs. Able to achieve 148dB of output and 88dB maximum gain the product is available in a 4, 6 or 12 channel configuration. Using a customized dual receiver the Boost is able achieve these power levels while maintaining stable performance free of feedback. Standard features include low level expansion, adaptive feedback cancellation, adaptive directional microphones (6 and 12 channel only), voice prompts, up to 4 memories and rocker volume control. The elegant case design provides the smallest possible packaging while still utilizing a 675 battery.</p>','full_text' => '','intro_image' => '','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '1','show_rating' => '1','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-01-15 16:59:20','updated_by' => '1','updated_at' => '2015-12-16 17:17:23'));
        $this->insert('{{%content}}', array('id' => '4','title' => 'BOOST - 148/88dB SUPER POWER BTE NOW Featuring iScroll®','category_id' => '4','tags' => '','intro_text' => '<p>Auditiva Inc. (Longwood, FL) announces the release of the Boost&reg; featuring iScroll&reg;. iScroll digital volume control offers a smooth easy-to-adjust gliding roller for those who may have limited dexterity. Achieving 148dB of output and 88dB maximum gain the product is now available with iScroll volume control in a 4, 6 or 12 channel configuration. Employing a customized dual receiver the Boost achieves these power levels while maintaining stable performance free of feedback. Standard features include low level expansion, adaptive feedback cancellation, adaptive directional microphones (6 and 12 channel only), voice prompts, t-coil, and up to 4 memories. The elegant case design provides the smallest possible packaging while still utilizing a 675 battery.</p>','full_text' => '','intro_image' => 'news/boost-pair-img.jpg','intro_image_float' => 'right','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '1','show_rating' => '1','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-01-15 17:38:04','updated_by' => '1','updated_at' => '2015-12-16 17:16:56'));
        $this->insert('{{%content}}', array('id' => '5','title' => 'IIC (Invisible-In-The-Canal)','category_id' => '8','tags' => '','intro_text' => '<p>Ultra-tiny, completely invisible hearing devices are the latest advancement in hearing technology. These hearing aids are similar to traditional CICs, but they are smaller in size and fit deep into the ear canal, making them impossible to see when worn.</p>','full_text' => '','intro_image' => 'styles/stylesIIC_thumb.jpg','intro_image_float' => 'left','main_image' => 'styles/stylesIIC_lg.jpg','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '1','show_rating' => '1','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-01-22 18:05:25','updated_by' => '1','updated_at' => '2015-11-06 15:50:54'));
        $this->insert('{{%content}}', array('id' => '6','title' => 'CIC (Completely-In-The-Canal)','category_id' => '8','tags' => '','intro_text' => '<p>Completely-in-the-canal custom-fit devices fit all the way in the ear canal. They are barely visible and cosmetically appealing. Some hearing aid wearers with nARCOw ear canals may not be candidates for CICs. These tiny hearing instruments are most suitable for mild to moderate losses.&nbsp;</p>','full_text' => '','intro_image' => 'styles/stylesCIC_thumb.jpg','intro_image_float' => 'left','main_image' => 'styles/stylesCIC_lg.jpg','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '1','show_rating' => '1','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-01-26 14:33:07','updated_by' => '1','updated_at' => '2015-02-17 11:32:37'));
        $this->insert('{{%content}}', array('id' => '7','title' => 'ITC (In-The-Canal)','category_id' => '8','tags' => '','intro_text' => '<p>In-the-canal custom-fit hearing aids are smaller than ITEs and are partially visible in the outer ear. In-the-canal devices are best for mild to moderate losses, but can be used by some patients with moderately severe losses.</p>','full_text' => '','intro_image' => 'styles//stylesITC_thumb.jpg','intro_image_float' => 'left','main_image' => 'styles/stylesITC_thumb.jpg','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '1','show_rating' => '1','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-01-26 14:35:19','updated_by' => '1','updated_at' => '2015-02-17 11:56:47'));
        $this->insert('{{%content}}', array('id' => '8','title' => 'ITE (In-The-Ear)','category_id' => '8','tags' => '','intro_text' => '<p>In-the-ear hearing aids have the circuitry built into a custom earmold that fills most of the visible portion of the ear, often referred to as a full-shell instrument. ITEs are best suited for mild to moderately severe hearing losses. ITEs are ideal for those with limited dexterity because of their sizeand easy-to-use controls.</p>','full_text' => '','intro_image' => 'styles/stylesITE_thumb.jpg','intro_image_float' => 'left','main_image' => 'styles/stylesITE_thumb.jpg','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '1','show_rating' => '1','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-01-26 14:35:55','updated_by' => '1','updated_at' => '2015-02-17 11:57:38'));
        $this->insert('{{%content}}', array('id' => '9','title' => 'Open Fit / RIC','category_id' => '8','tags' => '','intro_text' => '<p>Open Fit and RIC hearing aids are similar to traditional behind-the-ear hearing aids in that the shell fits behind the ear, but these are smaller and less noticeable than traditional BTEs. These Open Fit and RIC aids typically have a thin acoustic tube or transmission wire (in receiver-in-canal-instruments) that connects the shell to an open-fit ear bud or a custom earmold.</p>','full_text' => '','intro_image' => 'styles/stylesMiniBTE_thumb.jpg','intro_image_float' => 'left','main_image' => 'styles/stylesMiniBTE_thumb.jpg','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-01-26 15:14:17','updated_by' => '1','updated_at' => '2015-02-17 11:58:11'));
        $this->insert('{{%content}}', array('id' => '10','title' => 'BTE (Behind-In-Ear)','category_id' => '8','tags' => '','intro_text' => '<p>In behind-the ear hearing aids, the receiver, microphone and amplifier are housed in a shell that fits behind the ear. A clear plastic tube connects the hearing aid to a custom earmold worn in the ear. Because of their large shell size, BTEs can hold more circuitry than other styles. BTEs can be fitted for people with a wide range of hearing losses.&nbsp;</p>','full_text' => '','intro_image' => 'styles/stylesBTE_thumb.jpg','intro_image_float' => 'left','main_image' => 'styles/stylesBTE_thumb.jpg','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-01-26 15:14:50','updated_by' => '1','updated_at' => '2015-02-17 11:58:35'));
        $this->insert('{{%content}}', array('id' => '11','title' => 'Hearing Loss','category_id' => '7','tags' => '','intro_text' => '<p>Hearing loss typically occurs gradually over a long span of time. Because the loss is not sudden, the effects may be difficult to recognize. The same is often true of failing eyesight, when signs are not as clear and reading small print becomes difficult. With hearing loss, we begin to adjust to hearing changes and forget the clarity of sound we enjoyed with normal hearing.</p>','full_text' => '<h3>Signs of Hearing Loss</h3>
        <p><img src="../media/consumers/signsOfLoss.jpg" alt="" width="500" height="343" align="right" />Hearing loss typically occurs gradually over a long span of time. Because the loss is not sudden, the effects may be difficult to recognize. The same is often true of failing eyesight, when signs are not as clear and reading small print becomes difficult. With hearing loss, we begin to adjust to hearing changes and forget the clarity of sound we enjoyed with normal hearing.</p>
        <p>Because early diagnosis and treatment is important, the first step is recognizing the most common signs of hearing loss. It may be time to visit a hearing healthcare provider, if you experience some of the following:</p>
        <ul>
        <li>You have difficulty following a conversation in a noisy restaurant or crowded room.</li>
        <li>You find it difficult to hear or understand people, when you leave a noisy area.</li>
        <li>It seems like people are mumbling or speaking more softly than in the past.</li>
        <li>It is easier to understand men&rsquo;s voices than women&rsquo;s and children&rsquo;s voices.</li>
        <li>Friends and family have commented on your decreased hearing.</li>
        <li>You find whispered speech difficult to hear and understand.</li>
        <li>You find yourself watching facial ZIRCs, in order to understand someone speaking.</li>
        <li>You raise the volume on the television or radio louder than in the past.</li>
        <li>You worry about your ability to understand, you find yourself not visiting friends or family as often as you would like.</li>
        <li>You frequently ask others to repeat themselves.</li>
        <li>You have difficulty hearing clearly on the telephone.</li>
        <li>It is difficult to understand a speaker at a business meeting or service.</li>
        <li>You frequently hear a ringing or buzzing in your ears.</li>
        </ul>
        <h3>Types of Hearing Loss</h3>
        <p><img src="../media/consumers/typesOfLoss.jpg" alt="" width="500" height="343" align="right" /><strong>Conductive Hearing Loss</strong>&nbsp;&ndash; Originates from the outer or middle ear. &nbsp;Many conductive hearing loss sufferers are children, although it can affect adults. &nbsp;Causes may include middle ear infection, otosclerosis, cerumen (ear wax) blockage, outer ear deformity, punctured ear drum, or damaged middle ear bones. &nbsp;In most instances, this type of hearing loss can be treated medically or surgically.</p>
        <p><strong>Sensorineural Hearing Loss</strong>&nbsp;&ndash; The most common type of hearing loss is sometimes described as Nerve-related Deafness. &nbsp;The loss originates from nerve damage in the inner ear and reduces the quality and intensity of sound perception. &nbsp;Causes range from aging, heredity and infections to exposure to loud noise or abnormal fluid volume. &nbsp;While this hearing loss is permanent, effective treatment with a hearing instrument amplifies sound and increases hearing sensitivity.</p>
        <p><strong>Mixed Hearing Loss</strong>&nbsp;&ndash;This type of hearing loss originates in both the outer or middle ear and the inner ear (mixed/combination of conductive and sensorineural hearing loss) and can include surgical and hearing instrument treatment options.&nbsp;</p>
        <p><strong>Central Hearing Loss</strong>&nbsp;&ndash;&nbsp;This type of hearing loss originates from damage or impairment to the nerves of the central nervous system (CNS), either in the pathways to the brain or in the brain itself.</p>
        <h3>Hearing Loss Evaluation</h3>
        <p>A hearing evaluation is a series of quick and easy tests to&nbsp;determine an individual&rsquo;s ability to hear.&nbsp;A hearing evaluation may include:</p>
        <p><strong>Patient History</strong>&nbsp;&ndash;&nbsp;Reviews of your medical and hearing history.</p>
        <p><strong>Otoscopy</strong>&nbsp;&ndash;&nbsp;Your ears are visible examined using a lighted&nbsp;magnifier to determine the condition of the ear canals and ear drums.</p>
        <p><strong>Tympanometry&nbsp;</strong>&ndash;&nbsp;A simple pressure test to assess middle ear function.</p>
        <p><strong>Audiometry</strong>&nbsp;&ndash;&nbsp;Testing performed with &nbsp;headphones or insert earphones to find the softest levels of sound you can hear. Tones or beeps as well as speech may be used. The results are then graphed on an audiogram, which shows if there is hearing loss as well as the type and configuration of the hearing loss.</p>
        <p>During a hearing evaluation, you will hear a series of tones or &ldquo;beeps&rdquo; in one ear at a time. The tones will get softer and softer. You will be asked to respond by either raising your hand or pressing a button whenever you hear the sound. The hearing healthcare professional will find the point at which you can just barely hear the sound for several different frequencies. These points are referred to as your thresholds.&nbsp;Note: Frequencies correspond to the perception of pitch, such as a fog horn (low frequency sound) or a flute (high frequency sound).</p>
        <h4>Audiogram</h4>
        <p><img src="../media/consumers/audiogramWith.jpg" alt="" width="380" height="349" align="right" />The results of the hearing evaluation are recorded on a special graph called an audiogram. The audiogram shows your hearing ability across a range of frequencies. Typical low frequencies sounds include men&rsquo;s voices, background noise, and vowel sounds while women&rsquo;s and children&rsquo;s voices and soft consonant sounds are usually higher in frequency.</p>
        <p>The vertical lines (top to bottom) on the audiogram represent the different frequencies from the low to high pitch. Moving left to right on the audiogram would be comparable to moving from left to right on a piano keyboard. Although the human ear can hear frequencies from 20 &ndash; 20,000 Hz, the frequencies most crucial for understanding speech are between 500 to 4000 Hz.</p>
        <p>The horizontal lines (side to side) on the audiogram represent the level of loudness or intensity of a sound. The 0 decibel (dB) line near the top of the audiogram represents an extremely soft sound. Each horizontal line located below the 0 line represents a louder sound. Moving from top to bottom is similar to increasing the volume control on a radio or television.</p>
        <p>Each point located on the audiogram represents the individual&rsquo;s threshold for a particular frequency, which is at a certain level of loudness. The red Os represent the thresholds for the right ear and the blue Xs represent the thresholds for the left ear.</p>
        <h4>Degrees of Hearing Loss</h4>
        <p>Thresholds of 0-15dB for children and 0-25 dB for adults are considered, medically to be within normal limits. The audiogram depicted here demonstrates the different degrees of hearing loss.</p>
        <h4>Speech Testing</h4>
        <p>The hearing healthcare professional may conduct two or more speech tests. The most common two are described here:</p>
        <ol>
        <li>The Speech Recognition Test (SRT) is a speech test in which you will be asked to repeat two-syllable words (i.e. hot dog, railroad and northwest).</li>
        <li>During the Word Discrimination Test, you will hear a list of one syllable words (i.e., dad, twins, owl) at a comfortable listening level.</li>
        </ol>
        <p>The hearing professional uses speech tests to determine how well you are able to differentiate between speech sounds. In other words, how well you understand speech without context and facial ZIRCs.</p>
        <h4>After the Hearing Evaluation</h4>
        <p>&nbsp;The hearing healthcare professional will discuss the results of your tests and make any necessary recommendations.</p>','intro_image' => 'consumers/hearingLoss.png','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '0','created_at' => '2015-02-12 12:03:47','updated_by' => '1','updated_at' => '2017-12-08 16:31:42'));
        $this->insert('{{%content}}', array('id' => '12','title' => 'Managing Expectations','category_id' => '7','tags' => '','intro_text' => '<p>If you know what to expect from your hearing aids, you\'ll be free to enjoy the improvements they can make in your life. Hearing instruments are much like eyeglasses &ndash; they improve vision without curing the underlying reasons for vision loss. In the same way, hearing instruments are aids to better hearing but neither cure hearing loss nor restore perfect hearing. Each individual has unique experiences and a specific type and degree of hearing loss. It is important to have reasonable expectations to avoid the frustration that can come from expecting results that cannot be achieved.</p>','full_text' => '<h4>Adjust to better hearing, better living</h4>
        <ul>
        <li><img src="../media/consumers/managingExpectations.jpg" alt="" width="500" height="343" align="right" />With your sophisticated hearing device, you should be able to hear the special sounds of your life &ndash; the words of your loved ones and the many normal sounds that you may not have realized you were no longer hearing.</li>
        <li>Everyday sounds - You may begin to hear sounds you have forgotten were a part of your world - the hum of appliances or the buzz of fluorescent lights.</li>
        <li>Easier listening - Hearing aids should allow you to understand speech more clearly, with less effort, in a variety of environments.</li>
        <li>Improved hearing - Hearing aids will improve your hearing but may not restore your hearing to normal.</li>
        </ul>
        <h4>Adjustment period</h4>
        <p>Learn to enjoy those special sounds again</p>
        <p>With your new hearing aids, learning to listen requires a period of adjustment and a measure of patience. Some people almost automatically adjust to hearing aids and appreciate the benefits offered by the hearing instrument right away. The majority of new hearing aid users need time to adjust to all the sounds they are now hearing. You may need to learn to ignore unwanted sounds, just as you did with normal hearing. It is also important to be realistic and not to expect 100 percent hearing in every situation. You will find that the longer you wear your hearing instrument, the more natural sounds and speech comprehension will become.</p>
        <h4>Helpful steps to adjust to your new hearing instrument</h4>
        <ul>
        <li>Initially, wear in your own home environment, where you are comfortable</li>
        <li>Wear your instruments, as long as you comfortably can, gradually increasing the length of time you wear them over a few weeks.</li>
        <li>Get used to your hearing instruments, while conversing one-on-one.</li>
        <li>Do not strain to hear every word&mdash;even people with normal hearing do not always hear every single word.</li>
        <li>Listening in background noise may be difficult, but do not be discouraged. People with normal hearing also have difficulty hearing with noise in the background.</li>
        <li>Practice locating the source of sound by only listening.</li>
        <li>Slowly increase your tolerance for loud sounds. Listen to something read aloud (books on tape from your local library are good choices).</li>
        <li>Gradually extend the number of people with whom you converse.</li>
        <li>Consider taking part in an organized aural rehabilitation course. Your hearing healthcare provider can offer further information about available courses.</li>
        </ul>
        <h4>Adjustment Issues</h4>
        <p>You may encounter some of the following occurrences during your adjustment period:</p>
        <ul>
        <li>Your own voice may sound different. With time, you should adapt to hearing your voice in a new way. If you continue to find it difficult to become accustomed to your voice, you may need to make a follow-up appointment with your hearing healthcare provider for possible adjustments to your hearing devices.</li>
        <li>Some individuals experience a "plugged-up" or obstructed feeling if you are fitted with custom hearing aids, these styles of instruments occupy physical space in your ear canal and may cause this sensation. This typically decreases within a few days as you adjust to your new instruments. If you find that you continue to experienced the plugged-up feeling, contact your hearing healthcare professional who can adjust the programming or modify the fit. An open-fit or large vent hearing aid reduces or eliminates this sensation.</li>
        <li>You may experience feedback. A whistling sound can occur when the amplified sound re-enters the hearing instrument and is re-amplified. Feedback is normal in certain situations, such as when inserting/removing a hearing aid or when placing a hand or another object near the hearing instrument. If feedback is present when speaking, chewing, changing positions or yawning; you should contact your hearing professional, so adjustments can be made to remedy the situation.</li>
        </ul>
        <h4>Reasonable expectations for hearing instruments</h4>
        <ul>
        <li>Be patient, it may take a period of six months to a year to adjust to all the sounds that are new again.</li>
        <li>Improved hearing in quiet (one-to-one communication, watching TV, etc.)</li>
        <li>Improved hearing in moderate background noise</li>
        <li>Soft speech should be audible, average speech comfortable. Loud speech should be loud (but not uncomfortable).</li>
        <li>Hearing instruments/ear molds should fit comfortably in your ears.</li>
        <li>Your voice should be &ldquo;acceptable&rdquo; to you.</li>
        <li>There should be no feedback, when hearing aids are properly seated in your ears.</li>
        <li>Ask your family and friends to help you by not shouting or mumbling; to get your attention before speaking to you; not to talk too fast or while eating; and be a distance of three to six feet from you when speaking.</li>
        </ul>
        <p>&nbsp;</p>','intro_image' => 'consumers/managingExpectations.jpg','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '0','created_at' => '2015-02-12 12:39:42','updated_by' => '1','updated_at' => '2015-11-16 14:37:22'));
        $this->insert('{{%content}}', array('id' => '13','title' => 'Treatment of Hearing Loss','category_id' => '7','tags' => '','intro_text' => '<p>Treatment options depend on the type of hearing loss, some types are medically or surgically correctible. However the majority of us have hearing loss that is sensorineural in nature which is effectively treated with hearing instruments, not by medications or surgery.</p>','full_text' => '<p><img style="float: right;" src="../media/consumers/treatmentOfLoss.jpg" alt="" width="500" height="343" />Treatment options depend on the type of hearing loss, some types are medically or surgically correctible. However the majority of us have hearing loss that is sensorineural in nature which is effectively treated with hearing instruments, not by medications or surgery.</p>
        <h4>Professional hearing evaluation</h4>
        <p>After completing a thorough evaluation, the hearing healthcare professional will discuss the results and recommendations with the individual, including how any hearing loss may be affecting her or his quality of life.</p>
        <p>Solutions will be offered, which may include hearing aids and assistive devices, such as personal listening systems (e.g., FM systems) or telephone amplifying devices. These potential solutions will be discussed in detail and the individual&rsquo;s listening needs and concerns will be taken into account, as well as cosmetic and financial concerns.</p>
        <p>Once the individual and the hearing healthcare professional have chosen the appropriate hearing aid to address the individuals lifestyle needs and hearing loss, the following steps may be expected:</p>
        <ol>
        <li>Ear Impressions -will be taken if being fitted with custom hearing instrument</li>
        <li>Hearing aid fitting- usually at a second appointment</li>
        <li>Follow up - to monitor progress and make any additional adjustments</li>
        </ol>
        <h4>Earmold impression</h4>
        <p>Earmold impressions are made by the hearing healthcare professional during an office visit. The procedure is necessary for any hearing instrument that will have a custom fit in the individual\'s ear. The process includes inserting an oto-block in the ear canal, which is a tiny soft sponge with a cord attached. Then a silicone material is gently injected into the canal to get a complete impression of the ear canal. Once the silicone material is set, the impression is gently pulled out of the ear and sent to Auditiva with the completed order form to have the hearing instruments built to the order. The entire procedure is quick and painless.</p>
        <h4>Follow-up visits</h4>
        <p>A follow-up appointment is usually scheduled a few weeks after the initial fitting to monitor the individual\'s progress and to make any necessary adjustments based on feedback shared by the individual wearing the new instruments.</p>
        <p>Additional follow-up appointments may be scheduled as needed to address any further concerns that the individual experiences and cleaning and maintenance.</p>','intro_image' => 'consumers/treatmentOfLoss.jpg','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '0','created_at' => '2015-02-12 12:41:59','updated_by' => '1','updated_at' => '2015-11-16 14:36:08'));
        $this->insert('{{%content}}', array('id' => '14','title' => 'Binaural Advantage','category_id' => '7','tags' => '','intro_text' => '<p>When a person has hearing loss in both ears, the hearing healthcare provider will usually recommend two hearing aids. This is because there are many benefits of hearing with two hearing aids. Similar to the way refractory problems in both eyes are treated with a pair of glasses, it makes sense that bilateral hearing loss should be treated with binaural hearing aids.</p>','full_text' => '<p><img style="float: right;" src="../media/consumers/whyTwoAids.jpg" alt="" width="500" height="343" />When a person has hearing loss in both ears, the hearing healthcare provider will usually recommend two hearing aids. This is because there are many benefits of hearing with two hearing aids. Similar to the way refractory problems in both eyes are treated with a pair of glasses, it makes sense that bilateral hearing loss should be treated with binaural hearing aids.</p>
        <h4>Better understanding of speech</h4>
        <p>By wearing two hearing aids rather than one, selective listening is more easily achieved. This allows your brain to focus on the conversation you want to hear. Research shows that people wearing two hearing aids routinely understand speech and conversation significantly better than people wearing one hearing aid.</p>
        <h3>Better understanding&nbsp;in groups and noisy situations</h3>
        <p>Speech intelligibility is improved in difficult listening situations when wearing two hearing aids.</p>
        <p>Better ability to tell the direction of sound - This is called localization. In a social gathering, for example, localization allows you to hear from which direction someone is speaking to you. Localization also helps you determine from which direction traffic is coming. Simply put, with binaural hearing, you will better detect where sounds are coming from in every situation. Better sound quality and balance - When you listen to a stereo system, you use both speakers to get the sharpest, most natural sound quality. The same can be said of hearing aids. By wearing two hearing aids, you increase your hearing range from 180 degrees reception with just one instrument, to 360 degrees. This greater range provides a better sense of balance and sound quality.</p>
        <h4>Wider hearing range</h4>
        <p>A person can hear sounds from a further distance with two ears, rather than just one. A voice that\'s barely heard at 10 feet with one ear can be heard up to 40 feet with two ears.</p>
        <h4>Better sound identification</h4>
        <p>Often, with just one hearing aid, many noises and words sound alike. But with two hearing aids, as with two ears, sounds are more easily distinguishable.</p>
        <h4>Smoother Tone Quality</h4>
        <p>Wearing two hearing aids generally requires less volume than one. The need for less volume results in less distortion and better reproduction of amplified sounds.</p>
        <h4>Keeps Both Ears Active</h4>
        <p>Research has shown that when only one hearing aid is worn, the unaided ear tends to lose its ability to hear and understand. This is clinically called the auditory deprivation effect. Wearing two hearing aids keeps both ears active.</p>
        <h4>Hearing is Less Tiring and Listening More Pleasant</h4>
        <p>More binaural hearing aid wearers report that listening and participating in conversation is more enjoyable with two instruments, instead of just one. This is because they do not have to strain to hear with the better ear. Thus, binaural hearing can help make life more relaxing.</p>
        <h4>Feeling of Balanced Hearing</h4>
        <p>Two-eared hearing results in a feeling of balanced reception of sound, also known as the stereo effect, whereas monaural hearing creates an unusual feeling of sounds being heard in one ear.</p>
        <h4>Greater Comfort when Loud Noises Occur</h4>
        <p>A lower volume control setting is required with two hearing aids than is required with one hearing aid. The result is a better tolerance of loud sounds.</p>
        <h4>Tinnitus Masking</h4>
        <p>About 50% of people with ringing in their ears report improvement when wearing hearing aids. If a person with tinnitus wears a hearing aid in only one ear, there will still be ringing in the ear that does not have a hearing aid.</p>
        <h4>Consumer Preference</h4>
        <p>An overwhelming majority of consumers who have hearing loss in both ears, choose two hearing aids over one, when given the choice to hear binaurally.</p>
        <p>Research with more than 5,000 consumers with hearing loss in both ears demonstrated that binaurally fit subjects are more satisfied than people fit with one hearing aid.</p>
        <p>Just as you use both eyes to see clearly, you need two ears to hear clearly. Your hearing healthcare professional can demonstrate to you the binaural advantage experience either through headphones (during testing), probe microphones, master hearing aids, or during your trial fitting.</p>','intro_image' => 'consumers/whyTwoAids.jpg','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '0','created_at' => '2015-02-12 12:42:51','updated_by' => '1','updated_at' => '2015-11-16 14:34:47'));
        $this->insert('{{%content}}', array('id' => '15','title' => 'Cleaning and Maintenance','category_id' => '7','tags' => '','intro_text' => '<p>Hearing instruments are durable and can withstand normal wear and handling, they are not indestructible. The majority of hearing instrument repairs are due to moisture damage and ear wax build-up. Following a few simple daily steps will extend the life and service of your hearing instruments.</p>','full_text' => '<p>Hearing instruments are durable and can withstand normal wear and handling, they are not indestructible. The majority of hearing instrument repairs are due to moisture damage and ear wax build-up. Following a few simple daily steps will extend the life and service of your hearing instruments.</p>
        <h4>Recommended Daily Care</h4>
        <p>After removing the hearing instrument from the ear at the end of each day, the exterior surface should be gently wiped with a clean, soft, lint-free cloth or moist cleaning wipes designed for hearing instruments. Do not allow water or any liquid to enter any of the openings on the instrument.</p>
        <p>Custom in the ear aids: Inspect the tip of the ear canal portion of the hearing instrument for any wax build-up. Using the wax tool supplied with the hearing instrument, carefully remove any wax from around the sound outlet. Be very careful not to push wax into the opening or to insert the tool deeply into the opening. Using the brush end of the tool, brush away the debris while holding the instrument with the sound outlet facing down so the loose wax falls away from the instrument.</p>
        <p>Behind-the-Ear aids with open-fit sound tubes and ear buds: Remove the sound tube from the body of the instrument following detailed instructions in the owner&rsquo;s manual that accompanied the hearing instrument. Use the cleaning rod (included with hearing instrument) to clean the sound tube and ear bud. Lightly &ldquo;push&rdquo; the cleaning rod through the sound tube, inserting at the opening where the tube attaches to the body of the instrument and push out through the ear bud. Gently wipe all components with a clean, soft, lint-free cloth or moist cleaning wipes designed for hearing instruments.</p>
        <p>Hearing instruments are exposed to moisture in the form of humidity and perspiration while being worn. The daily use of a dehumidifying system or drying kit approved by your hearing healthcare provider is highly recommended. These accessories may be purchased from your hearing healthcare professional. If you have any questions about the care of your instruments, contact your hearing healthcare provider.</p>
        <p><img src="../media/consumers/cleaningAll3.jpg" alt="" width="885" height="296" /></p>','intro_image' => 'consumers/cleaning-with-brush.jpg','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '0','created_at' => '2015-02-12 12:43:45','updated_by' => '1','updated_at' => '2015-11-16 14:32:21'));
        $this->insert('{{%content}}', array('id' => '16','title' => 'Batteries','category_id' => '7','tags' => '','intro_text' => '<p>There are four standard battery sizes used in today\'s hearing instruments. All hearing aid batteries are color coded with a tabbed label, the colors differentiate the battery size. This is according to a world-wide standard for the industry.</p>','full_text' => '<h4>Zinc Air Battery</h4>
        <p><img src="../media/consumers/batteries01.jpg" alt="" width="500" height="372" align="right" /></p>
        <p>There are four standard battery sizes used in today\'s hearing instruments. All hearing aid batteries are color coded with a tabbed label, the colors differentiate the battery size. This is according to a world-wide standard for the industry.&nbsp;</p>
        <p>All hearing instruments require a Zinc Air battery, which uses air outside the battery as a source of power. The colored label seals the air holes and ensures the freshness of the battery until it is needed. It is not recommended to re-attach the label when the battery is not in use, as this will not extend the life of the battery.</p>
        <ul>
        <li>Size 675: Blue</li>
        <li>Size 13: Orange</li>
        <li>Size 312 Brown</li>
        <li>Size 10: Yellow</li>
        </ul>
        <h4>Changing the Battery</h4>
        <ul>
        <li>With most digital hearing aids, you will get warning beeps indicating that your battery needs to be changed. The beeps will continue for several minutes until the battery becomes dead.</li>
        <li>With analog hearing aids, if you find that you need to turn the volume up more than usual, if sounds are distorted, or your hearing aid is dead, then it is time to change the battery.</li>
        <li>Follow the procedure outlined in the instruction manual that accompanied the hearing instrument(s) when replacing the battery.</li>
        <li>Lift the notch at the edge of the battery compartment and gently swing open the door. Remove the dead battery and properly dispose in a receptacle.</li>
        <li>Remove the color tab on the new battery and insert the battery with the "+" side facing up. Removing the tab will allow air to enter and activate the battery within a few seconds.</li>
        <li>Gently swing the door into the closed position. The compartment should close easily, do not force it. If resistance is noted, check that the battery is inserted correctly.</li>
        </ul>
        <h4>Proper Battery Storage</h4>
        <ul>
        <li>Always store batteries in dry places at room temperature.</li>
        <li>Do not store batteries in extreme temperatures such as a refrigerator, freezer, hot car or near a source of heat.</li>
        <li>Don\'t allow batteries to get wet, this will cause rapid erosion. If the battery gets wet, remove it from the hearing instrument and properly dispose. Remove any excess moisture from the battery compartment and insert a new, dry battery.</li>
        </ul>
        <h4>Tips to Remember About Hearing Aid Batteries</h4>
        <ul>
        <li>Batteries should not be carried loosely in your purse/pocket since metal objects, such as coins or keys, can short out a battery.</li>
        <li>Occasionally, batteries have been mistaken for pills, so always verify your medication before swallowing.</li>
        <li>Since hearing aid batteries can be tempting and easily swallowed by small children, always store and dispose of batteries out-of-reach of children.</li>
        <li>Hearing aid batteries are dangerous if swallowed. If swallowed, see a doctor immediately.</li>
        </ul>
        <p><strong>Important:</strong>&nbsp;<em>Always discard used batteries. Small batteries can be harmful if swallowed. Keep batteries out of the reach of pets and small children. In case of ingestion, contact your physician or, if in the US call the National Button Battery Hotline at (202) 625-3333.</em></p>','intro_image' => 'consumers/batteries01.jpg','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '0','created_at' => '2015-02-12 12:44:33','updated_by' => '1','updated_at' => '2016-01-25 14:45:48'));
        $this->insert('{{%content}}', array('id' => '17','title' => 'Auditiva Protects Hearing Aids with P2i Nano-coating Technology','category_id' => '4','tags' => '','intro_text' => '<p>Auditiva&reg; Hearing Instruments, Inc. is excited to now offer P2i nano-coating technology on their hearing aids. P2i is the world leader in liquid repellent nano-coating technology. Its revolutionary process creates an ultra-thin polymer layer that changes the surfaces properties and causes liquid to form beads and simply roll off. The result is truly durable liquid-repellent coating that substantially reduces repairs. Check out our <a href="https://youtu.be/sSL6ryXMyGA" target="_blank">YouTube video</a>.</p>','full_text' => '','intro_image' => 'news/veloz_vc_droplet.jpg','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-10-28 12:48:03','updated_by' => '1','updated_at' => '2015-12-16 17:17:07'));
        $this->insert('{{%content}}', array('id' => '18','title' => 'P2i Water Resistant Technology','category_id' => '9','tags' => '','intro_text' => '<p>Auditiva Protects Hearing Aids with P2i Nano-coating Technology</p>
        <ul>
        <li>Five times more durable than leading market competition.</li>
        <li>Moisture, sweat and body oils can all contribute to hearing aid breakdown and failure.</li>
        </ul>','full_text' => '<p><strong><img class="img-responsive" style="float: right;" src="../media/products/p2i-logo.png" alt="" width="250" height="113" /></strong><strong>How is P2i nano-coating technology applied?</strong></p>
        <p>The nano-coating is applied using a special pulsed ionized gas (plasma), the process bonds a nanoscopic polymer layer -- one thousand times thinner than a human hair -- to the hearing aid. This durable ultrathin fluoropolymer coating is applied to all internal and external components.</p>
        <p><strong>How does it work and help?</strong></p>
        <p>This high-tech coating system ensures that the sensitive electronic components are protected thus providing optimal durability and performance. P2i nano-coating dramatically lowers the product\'s liquid surface friction, so when humidity or sweat come into contact with a device, beads form and simply roll off.</p>
        <p><img class="img-responsive" src="../media/products/p2i-product-test.jpg" alt="P2i Product Test" /></p>
        <p>Visit out YouTube channel for video demos: <a href="https://www.youtube.com/channel/UCDnwW290SWy-PXE3O0bkG7A" target="_blank">Auditiva Channel</a></p>.
        <p><iframe src="https://www.youtube.com/embed/sSL6ryXMyGA" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe></p>','intro_image' => 'products/p2i-product-test.jpg','intro_image_float' => 'right','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-10-28 14:25:10','updated_by' => '1','updated_at' => '2016-08-17 09:47:03'));
        $this->insert('{{%content}}', array('id' => '19','title' => 'ZIRC','category_id' => '5','tags' => 'custom, iic','intro_text' => '<p>Totally invisible custom hearing aid available with our exclusive SoftTouch&trade; technology.</p>','full_text' => '<p>Totally invisible custom hearing aid available with our exclusive&nbsp;<em>SoftTouch</em>&trade; technology.</p>
        <p>Today, smaller components deliver bigger results. Introducing ZIRC&reg;, our totally invisible custom hearing aid available with our exclusive&nbsp;<em>SoftTouch</em>&trade; technology. A simple, soft touch to the ear allows wearers&nbsp;to change memories for different listening environments. ZIRC provides a discreet, custom-fit instrument with easy adjustments and increased capabilities in a smaller-than-ever size.</p>
        <ul>
        <li>Totally Invisible.</li>
        <li>Natural Venting.</li>
        <li><em>SoftTouch</em>&nbsp;Technology.</li>
        </ul>','intro_image' => 'products/iic-xtreme-canal-small.png','intro_image_float' => 'left','main_image' => 'products/iic-xtreme-canal-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 11:35:54','updated_by' => '908','updated_at' => '2016-02-25 09:04:07'));
        $this->insert('{{%content}}', array('id' => '20','title' => 'Invisible In Canal','category_id' => '5','tags' => 'custom, iic','intro_text' => '<p>Our Invisible In Canal style is now available on select INTUIR&reg; instruments with Feedback Cancellation.</p>','full_text' => '<p><br />Our Invisible In Canal style is now available on select INTUIR&reg; instruments with Feedback Cancellation.</p>
        <ul>
        <li>A precise prescriptive fitting.</li>
        <li>Totally Invisible.</li>
        <li>Flexible Programming.</li>
        </ul>','intro_image' => 'products/iic-xtreme-canal-small.png','intro_image_float' => 'left','main_image' => 'products/iic-xtreme-canal-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 12:12:43','updated_by' => '1','updated_at' => '2015-11-12 17:45:02'));
        $this->insert('{{%content}}', array('id' => '21','title' => 'INTUIR 12','category_id' => '5','tags' => 'custom','intro_text' => '<p>The INTUIR&reg; 12 offers maximum power output with low battery consumption &ndash; resulting in extended battery life. Available in all custom styles.</p>','full_text' => '<p><br />The INTUIR&reg; 12 offers maximum power output with low battery consumption &ndash; resulting in extended battery life. Available in all custom styles.</p>
        <p>Featuring nano chip technology that ensures accurate processing of the sounds you want to hear without distortion. Because of its patented system architecture, the INTUIR&reg; 12 offers maximum power output with low battery consumption &ndash; resulting in extended battery life. Available in all custom styles.</p>
        <ul>
        <li>Excellent fitting flexibility for improved listening comfort.</li>
        <li>Softwave&reg; System provides a clear signal even when abrupt sounds are present.</li>
        <li>Identifies unwanted noise and suppresses it without affecting incoming speech.</li>
        <li>8 compression channels (12 gain channels).</li>
        </ul>','intro_image' => 'products/custom-4-small.png','intro_image_float' => 'left','main_image' => 'products/custom-4-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 12:54:38','updated_by' => '908','updated_at' => '2016-02-17 13:09:45'));
        $this->insert('{{%content}}', array('id' => '22','title' => 'INTUIR 6','category_id' => '5','tags' => 'custom','intro_text' => '<p>The INTUIR&reg; 6 and INTUIR&reg; D55AD feature 6 independent compression channels and access to 12 independent gain bands thus providing greater flexibility in target matching.</p>','full_text' => '<p><br />The INTUIR&reg; 6 and INTUIR&reg; D55AD feature 6 independent compression channels and access to 12 independent gain bands thus providing greater flexibility in target matching.</p>
        <p>The next generation INTUIR&reg; circuitry features an accelerated feedback cancellation system working to stop feedback before it is perceived. The INTUIR&reg; 6 and INTUIR&reg; D55AD feature 6 independent compression channels and access to 12 independent gain bands thus providing greater flexibility in target matching.</p>
        <ul>
        <li>Adaptive Feedback Cancellation system.</li>
        <li>Environmental Recognition System for improved comfort in noisy situations.</li>
        <li>6 compression channels.</li>
        <li>6 MPO channels.</li>
        <li>12 gain bands.</li>
        </ul>','intro_image' => 'products/custom-4-small.png','intro_image_float' => 'left','main_image' => 'products/custom-4-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 12:56:50','updated_by' => '1','updated_at' => '2015-11-12 17:52:56'));
        $this->insert('{{%content}}', array('id' => '23','title' => 'INTUIR 4AD','category_id' => '5','tags' => 'custom','intro_text' => '<p>A full-shell instrument that offers our Adaptive Directionality&reg; system designed to smoothly transition between omni and directional microphones for listening environments where sounds are coming from various directions such as at a party. The AD system automatically switches without the push of a button.</p>','full_text' => '<p><br />A full-shell instrument that offers our Adaptive Directionality&reg; system designed to smoothly transition between omni and directional microphones for listening environments where sounds are coming from various directions such as at a party. The AD system automatically switches without the push of a button.</p>
        <ul>
        <li>Adaptive Feedback Cancellation system.</li>
        <li>Environmental Recognition System for improved comfort in noisy situations.</li>
        <li>Crisp, digital sound without distortion.</li>
        <li>4 compression channels (12 gain channels).</li>
        </ul>','intro_image' => 'products/custom-2-small.png','intro_image_float' => 'left','main_image' => 'products/custom-2-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 13:39:18','updated_by' => '1','updated_at' => '2015-11-12 17:54:01'));
        $this->insert('{{%content}}', array('id' => '24','title' => 'INTUIR 4+','category_id' => '5','tags' => 'custom','intro_text' => '<p>An advanced 4 compression channel instrument (12 gain channels) providing excellent versatility with multiple programs available for different listening environments such as dining in a restaurant, participating in a place of worship or enjoying a party.</p>','full_text' => '<p><br />An advanced 4 compression channel instrument (12 gain channels) providing excellent versatility with multiple programs available for different listening environments such as dining in a restaurant, participating in a place of worship or enjoying a party.</p>
        <ul>
        <li>Responds to background noise of all intensities.</li>
        <li>Automatically eliminates annoying whistling noise.</li>
        <li>Provides sound clarity and clear understanding of speech.</li>
        </ul>','intro_image' => 'products/custom-4-small.png','intro_image_float' => 'left','main_image' => 'products/custom-4-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 13:41:54','updated_by' => '1','updated_at' => '2015-11-12 17:54:47'));
        $this->insert('{{%content}}', array('id' => '25','title' => 'INTUIR 2','category_id' => '5','tags' => 'custom','intro_text' => '<p>An excellent entry-level digital hearing instrument offering 2 compression channels (10 gain channels) and up to four memories.</p>','full_text' => '<p>An excellent entry-level digital hearing instrument offering 2 compression channels (10 gain channels) and up to four memories.</p>
        <p>&nbsp;</p>
        <ul>
        <li>Dynamic Contrast Detection which enhances speech without distortion.</li>
        <li>Multi-memory tone indicator.</li>
        <li>Adjustable manual volume control.</li>
        </ul>','intro_image' => 'products/custom-3-small.png','intro_image_float' => 'left','main_image' => 'products/custom-3-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 13:46:49','updated_by' => '1','updated_at' => '2015-11-12 17:56:59'));
        $this->insert('{{%content}}', array('id' => '26','title' => 'INTUIR 2FC','category_id' => '5','tags' => 'custom','intro_text' => '<p>An advanced 2 compression channel instrument (12 gain channels) with the latest feedback cancellation system which constantly monitors and automatically eliminates whistling.</p>','full_text' => '<p><br />An advanced 2 compression channel instrument (12 gain channels) with the latest feedback cancellation system which constantly monitors and automatically eliminates whistling.</p>
        <ul>
        <li>Enhanced listener comfort while in conversations.</li>
        <li>Maximum resistance to tonal artifacts such as horns, timer alarms and bells.</li>
        <li>Multi-memory tone indicator.</li>
        </ul>','intro_image' => 'products/custom-4-small.png','intro_image_float' => 'left','main_image' => 'products/custom-4-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 15:51:33','updated_by' => '1','updated_at' => '2015-11-12 17:57:32'));
        $this->insert('{{%content}}', array('id' => '27','title' => 'INTUIR 2ER','category_id' => '5','tags' => 'custom','intro_text' => '<p>Offers all the great features of the INTUIR&reg; 2FC plus an Environmental Recognition System (ERS) - enhanced intelligent algorithms identifies unwanted background noise without suppressing the speech or other sounds that are important to the person wearing the instrument.</p>','full_text' => '<p><br />Offers all the great features of the INTUIR&reg; 2FC plus an Environmental Recognition System (ERS) - enhanced intelligent algorithms identifies unwanted background noise without suppressing the speech or other sounds that are important to the person wearing the instrument.</p>
        <ul>
        <li>Automatically adjusts unwanted background noise such as wind, motors and fans.</li>
        <li>Enhanced listener comfort while in conversations.</li>
        <li>Maximum resistance to tonal artifacts such as horns, timer alarms and bells.</li>
        </ul>','intro_image' => 'products/custom-4-small.png','intro_image_float' => 'left','main_image' => 'products/custom-4-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 15:53:18','updated_by' => '1','updated_at' => '2015-11-12 17:57:56'));
        $this->insert('{{%content}}', array('id' => '28','title' => 'LIGERO','category_id' => '5','tags' => 'custom','intro_text' => '<p>Simply put, this is the instrument offering digital technology with an easy-to-adjust configuration. No need for computers or software.</p>','full_text' => '<p><br />Simply put, this is the instrument offering digital technology with an easy-to-adjust configuration. No need for computers or software.</p>
        <ul>
        <li>Easy adjustments may be made by your hearing healthcare provider.</li>
        <li>Adjustable or automatic volume control is available.</li>
        <li>Available in all custom instrument styles.</li>
        </ul>','intro_image' => 'products/custom-3-small.png','intro_image_float' => 'left','main_image' => 'products/custom-3-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 15:55:06','updated_by' => '1','updated_at' => '2015-11-12 17:58:22'));
        $this->insert('{{%content}}', array('id' => '29','title' => 'LIGERO FC','category_id' => '5','tags' => 'custom','intro_text' => '<p>The LIGERO FC is a high fidelity 2 compression channel, trimmer adjustable instrument with the latest in adaptive feedback cancellation which reduces acoustic feedback or whistling.</p>','full_text' => '<p><br />The LIGERO FC is a high fidelity 2 compression channel, trimmer adjustable instrument with the latest in adaptive feedback cancellation which reduces acoustic feedback or whistling.</p>
        <p>This hearing instrument can be configured to precisely fit a wide range of hearing losses. Adjustments to the standard trimmer may be made by your hearing healthcare professional; two additional trimmers are available as an option.</p>
        <ul>
        <li>Adjustable on/off volume control.</li>
        <li>Optional Trimmers Available: low frequency, high frequency, gain, AGC-o output and threshold kneepoint.</li>
        <li>Low battery indicator.</li>
        <li>Available in completely-in-the-canal (CIC), Canal, and Full Shell Styles.</li>
        </ul>','intro_image' => 'products/custom-3-small.png','intro_image_float' => 'left','main_image' => 'products/custom-3-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 15:56:40','updated_by' => '1','updated_at' => '2015-11-12 17:58:52'));
        $this->insert('{{%content}}', array('id' => '30','title' => 'Briza (Family)','category_id' => '5','tags' => 'Open Fit','intro_text' => '<p>Offers the latest in advanced fitting technology in an open-fit in a 2, 4, or 12 channel instrument. The new Adaptive Feedback Cancellation system allows the instrument to adapt to changing feedback conditions up to 6 times faster than previous systems &ndash; 300 milliseconds rather than 1 to 2 seconds!</p>','full_text' => '<p><br />Offers the latest in advanced fitting technology in an open-fit in a 2, 4, or 12 channel instrument. The new Adaptive Feedback Cancellation system allows the instrument to adapt to changing feedback conditions up to 6 times faster than previous systems &ndash; 300 milliseconds rather than 1 to 2 seconds!</p>
        <ul>
        <li>Adaptive Directionality&reg; microphone that adjusts to what you want to hear.</li>
        <li>Environmental Recognition System for improved comfort in noisy situations.</li>
        <li>Softwave&reg; System provides a clear signal even when abrupt sounds are present.</li>
        </ul>','intro_image' => 'products/briza-ote-small.png','intro_image_float' => 'left','main_image' => 'products/briza-ote-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '0','created_by' => '1','created_at' => '2015-11-03 16:03:45','updated_by' => '1','updated_at' => '2016-05-03 13:53:26'));
        $this->insert('{{%content}}', array('id' => '31','title' => 'FINO (Family)','category_id' => '5','tags' => 'Open Fit','intro_text' => '<p>The FINO family of Receiver In the Canal products offers an ideal blend of flexible choices and powerful performance in a 2, 4, 6, or 12 channel circuitry.</p>','full_text' => '<p><br />The FINO family of Receiver In the Canal products offers an ideal blend of flexible choices and powerful performance in a 2, 4, 6, or 12 channel circuitry.</p>
        <p>Placing the receiver in the ear canal provides a natural listening experience without the clutter of background noise. &nbsp;The advanced technology of the FINO offers clear hearing in most environments allowing you to enjoy dining out, talking with friends and listening to the soft sounds of nature.</p>
        <ul>
        <li>Three (3) Hi-Def Receiver choices - Wideband, Power and High Power.</li>
        <li>Customized, natural comfort for a wide variety of hearing losses.</li>
        <li>Automatically eliminates distracting feedback (whistling) noise, allowing you to hear what you want to hear.</li>
        </ul>','intro_image' => 'products/fino-ote-small.png','intro_image_float' => 'left','main_image' => 'products/fino-ote-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '0','created_by' => '1','created_at' => '2015-11-03 16:11:51','updated_by' => '1','updated_at' => '2016-09-22 10:55:27'));
        $this->insert('{{%content}}', array('id' => '32','title' => 'VELOZ (Family)','category_id' => '5','tags' => 'Open Fit','intro_text' => '<p>The VELOZ&reg; Family of 312 Open-fit Products features a patented ergonomic design case created with our focus on the patient. The VELOZ&reg; family offers 3 technology levels 4, 6 and 12 channel circuitry for all types of lifestyle needs.</p>','full_text' => '<p>The VELOZ&reg; Family of 312 Open-fit Products features a patented ergonomic design case created with our focus on the patient. The VELOZ&reg; family offers 3 technology levels 4, 6 and 12 channel circuitry for all types of lifestyle needs.&nbsp;</p>
        <p>Key features include the iScroll&reg; Digital Volume Control, a smooth, easy-to-adjust roller for those who may have limited dexterity. The new push-button memory switch is effortless to locate and operate. Wear it over the ear (OTE) or behind the ear (BTE); with an open-fit ear bud or with a custom ear mold.</p>
        <ul>
        <li>Easy to adjust iScroll&reg; digital volume control.</li>
        <li>312 battery for up to 175 hours of battery life.</li>
        <li>3 technology levels for all types of active lifestyles.</li>
        </ul>','intro_image' => 'products/veloz-ote-2-small.png','intro_image_float' => 'left','main_image' => 'products/veloz-ote-2-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-03 16:13:24','updated_by' => '908','updated_at' => '2016-02-25 08:52:58'));
        $this->insert('{{%content}}', array('id' => '33','title' => 'Carousel Slide 1','category_id' => '2','tags' => 'What?','intro_text' => '<p>What? &nbsp;Can You Hear Me?</p>','full_text' => '','intro_image' => 'carousel/slide-1.jpg','intro_image_float' => 'none','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '0','show_intro' => '0','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '7','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-16 16:04:08','updated_by' => '0','updated_at' => '2016-01-05 10:33:47'));
        $this->insert('{{%content}}', array('id' => '34','title' => 'Carousel Slide 2','category_id' => '2','tags' => 'Boost fist','intro_text' => '<p>Boost Family of Super Power BTEs</p>','full_text' => '','intro_image' => 'carousel/slide-2.jpg','intro_image_float' => 'none','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '7','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-16 16:36:44','updated_by' => '908','updated_at' => '2016-01-05 10:34:55'));
        $this->insert('{{%content}}', array('id' => '35','title' => 'Carousel Slide 3','category_id' => '2','tags' => 'Boost banner','intro_text' => '<p>Boost Super Power BTEs</p>','full_text' => '','intro_image' => 'carousel/slide-3.jpg','intro_image_float' => 'none','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '7','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-16 17:16:27','updated_by' => '908','updated_at' => '2016-01-05 10:35:05'));
        $this->insert('{{%content}}', array('id' => '36','title' => 'Carousel Slide 4','category_id' => '2','tags' => 'ocean','intro_text' => '<p>Hear the ocean\'s surf</p>','full_text' => '','intro_image' => 'carousel/slide-4.jpg','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '7','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-16 17:17:10','updated_by' => '908','updated_at' => '2016-01-05 10:35:29'));
        $this->insert('{{%content}}', array('id' => '37','title' => 'Boost (Family)','category_id' => '5','tags' => 'BTE, Super Power','intro_text' => '<p>This Boost&reg; Family of Super Power BTEs with their&nbsp;elegant case design provides the smallest possible packaging while still utilizing a 675 battery.</p>','full_text' => '<p>This Boost&reg; Family of Super Power BTEs with their&nbsp;elegant case design provides the smallest possible packaging while still utilizing a 675 battery. The&nbsp;Boost&reg; family offers 3 technology levels 4, 6 and 12 channel circuitry for all types&nbsp;of lifestyle needs.&nbsp;</p
        <p>Key features include Multi-Memory Push Button up to 4 memories, Rocker Volume Control, Adaptive Feedback Cancellation, 675 battery.&nbsp;</p>','intro_image' => 'products/boost-bte-2-small.png','intro_image_float' => 'left','main_image' => 'products/boost-bte-2-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:45:16','updated_by' => '908','updated_at' => '2017-07-06 10:48:42'));
        $this->insert('{{%content}}', array('id' => '38','title' => 'BTE D55AD','category_id' => '5','tags' => 'BTE','intro_text' => '<p>The BTE&nbsp;D55AD features 6 independent compression channels and access to 12 independent gain bands thus providing greater flexibility in target matching.</p>','full_text' => '<p>The BTE&nbsp;D55AD features 6 independent compression channels and access to 12 independent gain bands thus providing greater flexibility in target matching.</p>
        <p>The next generation circuitry features an accelerated feedback cancellation system working to stop feedback before it is perceived. The BTE D55AD features 6 independent compression channels and access to 12 independent gain bands thus providing greater flexibility in target matching.</p>
        <ul>
        <li>Adaptive Feedback Cancellation system.</li>
        <li>Environmental Recognition System for improved comfort in noisy situations.</li>
        <li>6 compression channels</li>
        <li>6 MPO channels</li>
        <li>12 gain bands</li>
        </ul>','intro_image' => 'products/bte-bumpy-small.png','intro_image_float' => 'left','main_image' => 'products/bte-bumpy-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:46:19','updated_by' => '1','updated_at' => '2015-11-17 14:46:53'));
        $this->insert('{{%content}}', array('id' => '39','title' => 'VELOZ (with BTE Earhook)','category_id' => '5','tags' => 'BTE','intro_text' => '<p>The VELOZ&reg; Family of 312 Open-fit Products features a patented ergonomic design case created with our focus on the patient. The VELOZ&reg; family offers 3 technology levels 4, 6 and 12 channel circuitry for all types of lifestyle needs.&nbsp;</p>','full_text' => '<p>The VELOZ&reg; Family of 312 Open-fit Products features a patented ergonomic design case created with our focus on the patient. The VELOZ&reg; family offers 3 technology levels 4, 6 and 12 channel circuitry for all types of lifestyle needs.&nbsp;</p>
        <p>Key features include the iScroll&reg; Digital Volume Control, a smooth, easy-to-adjust roller for those who may have limited dexterity. The new push-button memory switch is effortless to locate and operate. Wear it over the ear (OTE) or behind the ear (BTE); with an open-fit ear bud or with a custom ear mold.</p>
        <ul>
        <li>Easy to adjust iScroll&reg; digital volume control.</li>
        <li>312 battery for up to 175 hours of battery life.</li>
        <li>3 technology levels for all types of active lifestyles.</li>
        </ul>','intro_image' => 'products/veloz-bte-2-small.png','intro_image_float' => 'left','main_image' => 'products/veloz-bte-2-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:48:35','updated_by' => '908','updated_at' => '2016-02-25 08:53:21'));
        $this->insert('{{%content}}', array('id' => '40','title' => 'INTUIR 4AD','category_id' => '5','tags' => 'BTE','intro_text' => '<p>INTUIR&reg; 4AD features state-of-the-art technology which results in crisp, digital sound without the distortion associated with previous generations of hearing instruments.&nbsp;</p>','full_text' => '<p>INTUIR&reg; 4AD features state-of-the-art technology which results in crisp, digital sound without the distortion associated with previous generations of hearing instruments.&nbsp;</p>
        <p>The Adaptive Directionality&reg; automatically switches between omni and directional response depending on noise in the environment. The INTUIR addresses a wider range of hearing loss than the majority of hearing instruments available today &ndash; up to 22dB added stable gain. It allows larger venting and more open fittings for better fit and patient comfort.</p>
        <ul>
        <li>Adaptive Feedback Cancellation system.</li>
        <li>Environmental Recognition System for improved comfort in noisy situations.</li>
        <li>Crisp, digital sound without distortion.</li>
        <li>4 compression channel (12 gain channels).</li>
        </ul>','intro_image' => 'products/intuir-bte-small.png','intro_image_float' => 'left','main_image' => 'products/intuir-bte-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:49:33','updated_by' => '1','updated_at' => '2015-11-17 14:49:33'));
        $this->insert('{{%content}}', array('id' => '41','title' => 'INTUIR 4+','category_id' => '5','tags' => 'BTE','intro_text' => '<p>An advanced BTE instrument with 4 compression channels (12 gain channels), providing excellent versatility with multiple programs available for different listening environments such as dining in a restaurant, participating in a place of worship or enjoying a party.</p>','full_text' => '<p>An advanced BTE instrument with 4 compression channels (12 gain channels), providing excellent versatility with multiple programs available for different listening environments such as dining in a restaurant, participating in a place of worship or enjoying a party.</p>
        <ul>
        <li>Responds to background noise of all intensities</li>
        <li>Automatically eliminates annoying whistling noise</li>
        <li>Provides sound clarity and clear understanding of speech</li>
        </ul>','intro_image' => 'products/intuir-bte-small.png','intro_image_float' => 'left','main_image' => 'products/intuir-bte-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:50:31','updated_by' => '1','updated_at' => '2015-11-17 14:50:31'));
        $this->insert('{{%content}}', array('id' => '42','title' => 'INTUIR 2FC','category_id' => '5','tags' => 'BTE','intro_text' => '<p>An advanced BTE instrument with 2 compression channels (12 gain channels) equipped with the latest feedback cancellation system which constantly monitors and automatically eliminates whistling.</p>','full_text' => '<p>An advanced BTE instrument with 2 compression channels (12 gain channels) equipped with the latest feedback cancellation system which constantly monitors and automatically eliminates whistling.</p>
        <ul>
        <li>Enhanced listener comfort while in conversations</li>
        <li>Maximum resistance to tonal artifacts such as horns, timer alarms and bells</li>
        <li>Multi-memory tone indicator</li>
        </ul>','intro_image' => 'products/intuir-bte-small.png','intro_image_float' => 'left','main_image' => 'products/intuir-bte-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:51:10','updated_by' => '1','updated_at' => '2015-11-17 14:51:10'));
        $this->insert('{{%content}}', array('id' => '43','title' => 'INTUIR 2','category_id' => '5','tags' => 'BTE','intro_text' => '<p>An excellent entry-level digital BTE hearing instrument offering 2 compression channels (12 gain channels), and up to four memories.</p>','full_text' => '<p>An excellent entry-level digital BTE hearing instrument offering 2 compression channels (12 gain channels), and up to four memories.</p>
        <ul>
        <li>Dynamic Contrast Detection which enhances speech without distortion.</li>
        <li>Multi-memory tone indicator.</li>
        <li>Adjustable manual volume control.</li>
        </ul>','intro_image' => 'products/intuir-bte-small.png','intro_image_float' => 'left','main_image' => 'products/intuir-bte-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:52:01','updated_by' => '1','updated_at' => '2015-11-17 14:52:01'));
        $this->insert('{{%content}}', array('id' => '44','title' => 'Opti-2','category_id' => '5','tags' => 'BTE','intro_text' => '<p>A trimmer-adjustable 2 compression channel digital BTE instrument with three trimmer adjustments for greater flexibility.</p>','full_text' => '<p>A trimmer-adjustable 2 compression channel digital BTE instrument with three trimmer adjustments for greater flexibility.</p>
        <ul>
        <li>Mode push-button with tone indicator</li>
        <li>Softwave&reg; System provides a clear signal even when abrupt sounds are present</li>
        <li>Preset memory and low battery tones</li>
        </ul>','intro_image' => 'products/intuir-bte-small.png','intro_image_float' => 'left','main_image' => 'products/intuir-bte-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:52:43','updated_by' => '1','updated_at' => '2015-11-17 14:52:43'));
        $this->insert('{{%content}}', array('id' => '45','title' => 'LIGERO 2P','category_id' => '5','tags' => 'BTE','intro_text' => '<p>A high fidelity programmable 2 compression channel BTE, trimmer-adjustable instrument which provides excellent versatility.</p>','full_text' => '<p>A high fidelity programmable 2 compression channel BTE, trimmer-adjustable instrument which provides excellent versatility.</p>
        <ul>
        <li>Softwave&reg; System provides a clear signal even when abrupt sounds are present.</li>
        <li>Multi-memory push button with tone indicator.</li>
        <li>Programmable memory and low battery tones.</li>
        </ul>','intro_image' => 'products/ligero-prog-small.png','intro_image_float' => 'left','main_image' => 'products/ligero-prog-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:53:36','updated_by' => '1','updated_at' => '2015-11-17 14:53:36'));
        $this->insert('{{%content}}', array('id' => '46','title' => 'LIGERO 2','category_id' => '5','tags' => 'BTE','intro_text' => '<p>A digital BTE with 2 compression channels, trimmer-adjustable instrument which provides excellent versatility.</p>','full_text' => '<p>A digital BTE with 2 compression channels, trimmer-adjustable instrument which provides excellent versatility.</p>
        <ul>
        <li>Softwave&reg; System provides a clear signal even when abrupt sounds are present.</li>
        <li>Mode push button with tone indicator.</li>
        <li>Low battery tones</li>
        </ul>','intro_image' => 'products/ligero-trimmer-small.png','intro_image_float' => 'left','main_image' => 'products/ligero-trimmer-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:54:36','updated_by' => '1','updated_at' => '2015-11-17 14:54:36'));
        $this->insert('{{%content}}', array('id' => '47','title' => 'BTE 278P','category_id' => '5','tags' => 'BTE','intro_text' => '<p>Offering with high output and high gain and fully programmable for up to 3 different listening environments.</p>','full_text' => '<p>Offering with high output and high gain and fully programmable for up to 3 different listening environments.</p>
        <ul>
        <li>Programmable memory and low battery tones.</li>
        <li>Numbered volume control.</li>
        <li>Preset expansion for quieter performance.</li>
        </ul>','intro_image' => 'products/ligero-prog-small.png','intro_image_float' => 'left','main_image' => 'products/ligero-prog-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:55:47','updated_by' => '1','updated_at' => '2015-11-17 14:55:47'));
        $this->insert('{{%content}}', array('id' => '48','title' => 'BTE 278','category_id' => '5','tags' => 'BTE','intro_text' => '<p>A single channel high output/high gain digital hearing instrument.</p>','full_text' => '<p>A single channel high output/high gain digital hearing instrument.</p>
        <ul>
        <li>Easy adjustments may be made by your hearing healthcare provider.</li>
        <li>Mode push button with tone indicator.</li>
        <li>Low battery tones.</li>
        </ul>','intro_image' => 'products/ligero-trimmer-small.png','intro_image_float' => 'left','main_image' => 'products/ligero-trimmer-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:57:11','updated_by' => '1','updated_at' => '2015-11-17 14:57:11'));
        $this->insert('{{%content}}', array('id' => '49','title' => 'Super 60','category_id' => '5','tags' => 'Super Power','intro_text' => '<p>Super 60 custom product offers&nbsp;up to 60dB of gain. Available as an option on custom instrument, fullshell style only.</p>','full_text' => '','intro_image' => 'products/custom-super-power-small.png','intro_image_float' => 'left','main_image' => 'products/custom-super-power-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 14:59:33','updated_by' => '1','updated_at' => '2015-11-17 14:59:33'));
        $this->insert('{{%content}}', array('id' => '50','title' => 'Super 70','category_id' => '5','tags' => 'Super Power','intro_text' => '<p>Super 70 custom product achieves up to 70dB maximum power to be used&nbsp;when fitting severe to profound losses. Available as an option on any fullshell custom digital instrument&nbsp;with a feedback canceller.</p>','full_text' => '<p>Super 70 custom product achieves up to 70dB maximum power to be used&nbsp;when fitting severe to profound losses. Available as an option on any fullshell custom digital instrument&nbsp;with a feedback canceller.</p>
        <p>Key features include:</p>
        <ul>
        <li>Multi-Memory Push Button up to 4 memories.</li>
        <li>External Volume Control.</li>
        <li>Adaptive Feedback Cancellation.</li>
        </ul>','intro_image' => 'products/custom-super-power-small.png','intro_image_float' => 'left','main_image' => 'products/custom-super-power-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 15:05:07','updated_by' => '1','updated_at' => '2015-11-17 15:05:07'));
        $this->insert('{{%content}}', array('id' => '51','title' => 'Stock Canal','category_id' => '5','tags' => 'Stock ITC','intro_text' => '<p>The Stock Canal&nbsp;device&nbsp;achieves performance and convenience&nbsp;to be used&nbsp;when fitting mild to moderate losses. Available with red and blue shells, 10a battery size and a variety of configurations. Programmable Digital and Trimpot Digital.</p>','full_text' => '','intro_image' => 'products/stockcanal-img-small.png','intro_image_float' => 'left','main_image' => 'products/stockcanal-img-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 15:06:13','updated_by' => '908','updated_at' => '2017-06-08 14:36:57'));
        $this->insert('{{%content}}', array('id' => '52','title' => 'InstaFIT','category_id' => '5','tags' => 'Stock ITC','intro_text' => '<p>The InstaFIT&reg;&nbsp;stock ITC device&nbsp;achieves performance and convenience&nbsp;to be used&nbsp;when fitting mild to moderate losses. Available in a variety of configurations. Programmable Digital and Trimpot Digital, 10a battery.</p>','full_text' => '','intro_image' => 'products/itc-stock-small.png','intro_image_float' => 'left','main_image' => 'products/itc-stock-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 15:07:04','updated_by' => '1','updated_at' => '2015-11-17 15:07:04'));
        $this->insert('{{%content}}', array('id' => '53','title' => 'Linear Custom','category_id' => '5','tags' => 'Linear Custom','intro_text' => '<p>Custom linear&nbsp;hearing instruments for easy adjustments using trimpots.</p>','full_text' => '<p>Custom linear&nbsp;hearing instruments for easy adjustments using trimpots.</p>
        <div>
        <p><img src="../media/products/analog-plus-logo.png" alt="classD-logo" width="200" /></p>
        <p>A custom hearing instrument with linear processing, and a standard trimpot. &nbsp;This model is digital circuit configured to replace the discontinued analog class &ldquo;D&rdquo; model.</p>
        <ul>
        <li>Easy adjustments may be made by your hearing healthcare provider</li>
        <li>Trimpot options available. &nbsp;One trimpot standard, Low Cut, High Cut or&nbsp;AGC-o</li>
        <li>Plus Power option available</li>
        </ul>
        </div>','intro_image' => 'products/custom-3-small.png','intro_image_float' => 'left','main_image' => 'products/custom-3-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 15:11:54','updated_by' => '1','updated_at' => '2015-11-17 15:12:45'));
        $this->insert('{{%content}}', array('id' => '54','title' => 'Pre-wire Kits','category_id' => '5','tags' => 'Pre-wire Kits','intro_text' => '<p>Pre-Wire Kits featuring a complete line for all custom shell styles with a full range of programmable digital and trimpot digital circuitry. Faceplates are offered in flat or contoured with a wide range of colors available.&nbsp;All components are obtainable in semi knock down kits (SKD) or complete kits.</p>','full_text' => '','intro_image' => 'products/faceplate-colors-4-small.jpg','intro_image_float' => 'left','main_image' => 'products/faceplate-colors-4-small.jpg','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-11-17 15:14:02','updated_by' => '1','updated_at' => '2015-11-17 15:14:02'));
        $this->insert('{{%content}}', array('id' => '55','title' => 'BOOST Super Power BTE','category_id' => '4','tags' => '','intro_text' => '<p>Announcing one of the most powerful hearing aids available. Choose from various models.</p>','full_text' => '<p><img src="../media/carousel/slide-2.jpg" alt="slide-2" />Auditiva&reg; Introduces the Boost&reg; Family of SUPER POWER BTEs. Able to achieve 148dB of output and 88dB maximum gain the product is available in a 4, 6 or 12 channel configuration. Using a customized dual receiver, the Boost is able achieve these power levels while maintaining stable performance free of feedback.</p>
        <p>Standard features include:</p>
        <ul>
        <li>Low level expansion</li>
        <li>Adaptive feedback cancellation</li>
        <li>Adaptive directional microphones (6 and 12 channel only)</li>
        <li>Voice prompts</li>
        <li>Up to 4 memories</li>
        <li>Rocker volume control</li>
        </ul>
        <p>The elegant case design provides the smallest possible packaging while still utilizing a 675 battery.</p>','intro_image' => 'carousel/slide-2.jpg','intro_image_float' => 'right','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2015-12-16 17:15:57','updated_by' => '1','updated_at' => '2018-01-04 16:43:19'));
        $this->insert('{{%content}}', array('id' => '59','title' => 'Carousel Slide 5','category_id' => '2','tags' => 'ARCO OTE','intro_text' => '<p>ARCO OTE</p>','full_text' => NULL,'intro_image' => 'carousel/slide-5.jpg','intro_image_float' => 'none','main_image' => NULL,'main_image_float' => 'none','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '0','show_intro' => '0','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '7','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2016-01-15 16:57:16','updated_by' => '1','updated_at' => '2016-07-29 11:27:58'));
        $this->insert('{{%content}}', array('id' => '60','title' => 'Auditiva\'s 17th Annual Southeast Regional CEU Workshop','category_id' => '4','tags' => '','intro_text' => '<p>Auditiva 17th Annual Southeast Regional Continuing Education Workshop was held this past month January 22-23, 2016 in Orlando, FL. It offered up to 16 continuing education hours for audiologist and hearing instrument specialists, including the 3 required courses for the state of Florida. &nbsp;Attendees gathered from over United State and internationally to take part in the continuing education workshop. In addition to the 16 continuing education hours made available through the workshop, attendees enjoyed breakfast, lunch and a cocktail reception Friday evening. Throughout the two day event attendees interacted with exhibitors from Audio Energy, Precision Earmold Labs and others. Auditiva&rsquo;s 18th Annual Southeast Regional CEU Workshop will be held January 27-28, 2017 in Orlando, Florida.</p>','full_text' => '','intro_image' => '','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '906','created_at' => '2016-02-08 15:28:28','updated_by' => '1','updated_at' => '2016-02-08 15:43:42'));
        $this->insert('{{%content}}', array('id' => '61','title' => 'Introducing ARCO® Open Fit Family','category_id' => '4','tags' => 'ARCO, Open Fit','intro_text' => '<p class="MsoNormal">Auditiva&rsquo;s New ARCO&reg; Family of Open Fit Instruments offers next generation hearing technology in a compact case design.&nbsp;</p>','full_text' => '<p class="MsoNormal"><img src="../media/products/ARCO-Ortho-L-AllColors-v3.jpg" alt="" width="300" height="196" /></p>
        <p class="MsoNormal">Auditiva&rsquo;s New ARCO&reg; Family of Open Fit Instruments offers next generation hearing technology in a compact case design. The instrument features a 312 battery; a New &ldquo;<em>Power Seal Thin Tube</em>,&rdquo; capturing high fidelity sound, 24-bit processor, Optimized &ldquo;Dual Sound Computing Power,&rdquo; available in 2, 6 and 12 channels. The ARCO Open Fit &ldquo;<em>Power Seal Thin Tube&rdquo; </em>system, microphone and &ldquo;Dual Sound Computing Power&rdquo; unite to minimize the chance of feedback. The environmental recognition system combines with twelve channel layered noise reduction to reduce unwanted background noise and minimize occlusion, thus providing for a more natural listening experience. The state of the art adaptive directionality algorithm in the ARCO D55AD and ARCO 12 offers constant stability of directional acoustic patterns for improved listening comfort. P2i nano-coating is available for increased moisture protection.</p>','intro_image' => 'products/arco-ortho-l-allcolors-v3.jpg','intro_image_float' => 'left','main_image' => '','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '1','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '906','created_at' => '2016-04-01 13:23:55','updated_by' => '1','updated_at' => '2018-01-04 16:59:04'));
        $this->insert('{{%content}}', array('id' => '62','title' => 'ARCO® Open Fit (Family)','category_id' => '5','tags' => 'ARCO, Open Fit','intro_text' => '<p class="MsoNormal">Auditiva&rsquo;s New ARCO &reg; Family of Open Fit Instruments offers next generation hearing technology in a compact case design.&nbsp;</p>','full_text' => '<p class="MsoNormal">Auditiva&rsquo;s New ARCO &reg; Family of Open Fit Instruments offers next generation hearing technology in a compact case design.</p>
        <p class="MsoNormal">The instrument features a 312 battery; a New &ldquo;<em>Power Seal Thin Tube</em>,&rdquo; capturing high fidelity sound, 24-bit processor, Optimized &ldquo;Dual Sound Computing Power,&rdquo; available in 2, 6 and 12 channels. The ARCO Open Fit &ldquo;<em>Power Seal Thin Tube&rdquo; </em>system, microphone and &ldquo;Dual Sound Computing Power&rdquo; unite to minimize the chance of feedback.</p>
        <p class="MsoNormal">The environmental recognition system combines with twelve channel layered noise reduction to reduce unwanted background noise and minimize occlusion, thus providing for a more natural listening experience.</p>
        <p class="MsoNormal">The state of the art adaptive directionality algorithm in the ARCO D55AD and ARCO 12 offers constant stability of directional acoustic patterns for improved listening comfort. P2i nano-coating is available for increased moisture protection.</p>
        <p class="MsoNormal">It supports Softwave&reg; System - advanced technology provides a clear comfortable signal even when abrupt irritating noises are present.&nbsp;The Softwave System is constantly working to monitor incoming sound. When the detector sees that there is a signal appearing at the input that is much larger than the long-term average measurement in the detector, the FAST mode is triggered, and the fast attack and release times are applied. The benefit of the Softwave detection is that the compressor gain can be reduced by the time the large signal hits the compressor, so that &lsquo;overshoot&rsquo; does not occur, which may cause clipping distortion.</p>','intro_image' => 'products/arco-ote-small.png','intro_image_float' => 'left','main_image' => 'products/arco-ote-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2016-04-01 16:10:02','updated_by' => '1','updated_at' => '2017-06-06 12:14:36'));
        $this->insert('{{%content}}', array('id' => '63','title' => 'Carousel Slide 6','category_id' => '2','tags' => 'ARCO RIC','intro_text' => '<p>ARCO RIC</p>','full_text' => NULL,'intro_image' => 'carousel/slide-6.jpg','intro_image_float' => 'none','main_image' => NULL,'main_image_float' => 'none','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '7','featured' => '0','ordering' => '0','publish_up' => '2016-08-15 00:00:00','publish_down' => NULL,'status' => '1','created_by' => '1','created_at' => '2016-07-29 11:29:28','updated_by' => '1','updated_at' => '2016-08-09 14:06:15'));
        $this->insert('{{%content}}', array('id' => '64','title' => 'ARCO® Family of Receiver in Canal Instruments Now Available ','category_id' => '4','tags' => 'ARCO, RIC','intro_text' => '<p>Auditiva introduces the all new ARCO&reg; Family of Receiver in Canal instruments offering next generation hearing technology in a compact case design.</p>','full_text' => '<p>Auditiva introduces the all new ARCO&reg; Family of Receiver in Canal instruments offering next generation hearing technology in a compact case design.</p>
        <p>A 24-bit processor for optimized dual sound computing is at the core of the 2, 6 and 12 channel devices.&nbsp; Features include voice prompts for memory position, a third generation adaptive feedback providing faster adaptation time, thus allowing for higher added stable gain. The environmental recognition system employs a layered noise reduction algorithm reducing background sounds in noisy environments and noise between speech, creating the clearest sound possible.</p>
        <p>Hi-Def receiver options include Wideband, Power and High Power receivers achieving ARCO&rsquo;s ultimate flexibility in a compact design. P2i nano-coating is available for increased moisture protection.</p>','intro_image' => 'products/arco-ric-3-colors.png','intro_image_float' => 'right','main_image' => 'products/arco-ric-small.png','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '1','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '906','created_at' => '2016-08-16 09:36:09','updated_by' => '1','updated_at' => '2018-01-04 16:58:50'));
        $this->insert('{{%content}}', array('id' => '65','title' => 'ARCO® RIC (Family)','category_id' => '5','tags' => 'Open Fit','intro_text' => '<p>The ARCO&reg; family of Receiver In the Canal products offers an ideal blend of flexible choices and powerful performance in a 2,6, or 12 channel circuitry.</p>','full_text' => '<p><br />The ARCO&reg; family of Receiver In the Canal products offers an ideal blend of flexible choices and powerful performance in a 2, &nbsp;6, or 12 channel circuitry.</p>
        <p>Placing the receiver in the ear canal provides a natural listening experience without the clutter of background noise. &nbsp;The advanced technology of the ARCO&reg; offers clear hearing in most environments allowing you to enjoy dining out, talking with friends and listening to the soft sounds of nature.</p>
        <ul>
        <li>Three (3) Hi-Def Receiver choices - Wideband, Power and High Power.</li>
        <li>Environmental recognition system employs a layered noise reduction algorithm reducing background sounds in noisy environments creating the clearest sound possible</li>
        <li>Third generation adaptive feedback canceler providing faster adaptation time, thus allowing for higher added stable gain</li>
        </ul>
        <p>It supports Softwave&reg; System - advanced technology provides a clear comfortable signal even when abrupt irritating noises are present. The Softwave System is constantly working to monitor incoming sound. When the detector sees that there is a signal appearing at the input that is much larger than the long-term average measurement in the detector, the FAST mode is triggered, and the fast attack and release times are applied. The benefit of the Softwave detection is that the compressor gain can be reduced by the time the large signal hits the compressor, so that &lsquo;overshoot&rsquo; does not occur, which may cause clipping distortion.</p>','intro_image' => 'products/arco-ric-small.png','intro_image_float' => 'left','main_image' => 'products/arco-ric-small.png','main_image_float' => 'right','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '1','featured' => '0','ordering' => '0','publish_up' => NULL,'publish_down' => NULL,'status' => '1','created_by' => '908','created_at' => '2016-08-16 09:45:56','updated_by' => '1','updated_at' => '2017-06-06 12:14:58'));
        $this->insert('{{%content}}', array('id' => '66','title' => 'Carousel Slide 7','category_id' => '2','tags' => 'Pico, Nano, Power, Wireless','intro_text' => '<p>MIRUM &amp; SUITE Families of wireless solutions available as PICO RITE, NANO Open Fit and Power BTE.</p>
        <p>Mirum stand out for all the right reasons. &nbsp;With unmatched features and accessories in its class, let Mirum shine for you.</p>
        <p>Suite is Auditiva\'s most sophisticated hearing aid family featuring the Audio Efficiency core technology. &nbsp;No matter which environment if available, Audio Efficiency technology orchestrates the right set of features and accessories. Suite Pico RITE is such a small but powerful device. &nbsp;With state-of-the-art technology, it has the potential to make a big difference in people\'s lives.</p>
        <p>Impressive Sound Quality and Comfort</p>
        <p>State-of the -art technology is brilliantly designed to enhance life\'s precious moments.</p>
        <ul>
        <li>ChannelFree: Auditiva\'s proven signal processing system provides a distinctively clear and natural sound quality. It is a unique gem among the industry.</li>
        <li>Noise Reduction Systems: Background noise, rustling newspaper or the clatter of silverware does not need to be such a threat to comfort. &nbsp;Neither does feedback. &nbsp;With feedback cancellers and noise reduction features, it provides a much more comfortable and less tiring hearing experience.</li>
        <li>Live Music &amp; Cinema Programs: The rich sound quality of the cinema or a live concert contributes to the overall experience. &nbsp;Auditiva\'s Live Music and Cinema Programs cater to the unique characteristics and wide dynamic range of these sound situations. Experience the cinema and live music in all its fullness.</li>
        </ul>
        <p>Auditiva provides everything needed for understanding speech better in challenging listening environments. Accessories can also make wearing a hearing aid easier and more comfortable than you might think.</p>','full_text' => '','intro_image' => 'carousel/slide-7.jpg','intro_image_float' => 'left','main_image' => '','main_image_float' => 'left','hits' => '0','rating_sum' => '0','rating_count' => '0','show_title' => '1','show_intro' => '1','show_image' => '1','show_hits' => '0','show_rating' => '0','content_type_id' => '7','featured' => '0','ordering' => '0','publish_up' => '2017-07-21 00:00:00','publish_down' => NULL,'status' => '0','created_by' => '1','created_at' => '2017-07-21 16:15:37','updated_by' => '1','updated_at' => '2018-01-04 16:41:47'));
    }
    
    public function addDataTableDistributor()
    {
        $this->insert('{{%distributor}}', [
            "first_name"      => "Marta",
            "last_name"       => "Pujol",
            "name_prefix"     => "Other",
            "occupation"      => "",
            "company_name"    => "To Hear",
            "address"         => "Blanco Encalada 2968, 2do Piso",
            "city"            => "Buenos Aires, Capital Federal",
            "state_prov"      => "",
            "postal_code"     => "",
            "country"         => "Argentina",
            "latitude"        => "",
            "longitude"       => "",
            "phone"           => "011-4781-3264",
            "fax"             => "",
            "email"           => "marsudes@hotmail.com",
            "website"         => "",
            "services"        => "Main Distributor",
            "hours"           => "",
            "instructions"    => "",
            'status'          => \app\models\User::STATUS_ACTIVE,
            'created_at'      => date("Y-m-d H:i:s"),
            'updated_at'      => date("Y-m-d H:i:s"),
            //'last_login'    => $this->datetime()
            "created_by"      => 1,
            "updated_by"      => 1,
        ]);
        $this->insert('{{%distributor}}', [
            "first_name"      => "",
            "last_name"       => "",
            "name_prefix"     => "Mr",
            "occupation"      => "",
            "company_name"    => "Rayan Samak Shenava",
            "address"         => "Shariati Ave, Kargar St, Building 35, Unit # 8",
            "city"            => "Tehran",
            "state_prov"      => "",
            "postal_code"     => "",
            "country"         => "Iran, Islamic Republic of",
            "latitude"        => "",
            "longitude"       => "",
            "phone"           => "+98-7762-8545",
            "fax"             => "+98-7762-8546",
            "email"           => "",
            "website"         => "",
            "services"        => "Distributor",
            "hours"           => "",
            "instructions"    => "",
            'status'          => \app\models\User::STATUS_ACTIVE,
            'created_at'      => date("Y-m-d H:i:s"),
            'updated_at'      => date("Y-m-d H:i:s"),
            //'last_login'    => $this->datetime()
            "created_by"      => 1,
            "updated_by"      => 1,
        ]);
        $this->insert('{{%distributor}}', [
            "first_name"      => "",
            "last_name"       => "",
            "name_prefix"     => "Mr",
            "occupation"      => "",
            "company_name"    => "Audivina",
            "address"         => "2F Lý thường Kiệt, P12 – Q5 – TPHCM",
            "city"            => "Ho Chi Minh City",
            "state_prov"      => "",
            "postal_code"     => "",
            "country"         => "Viet Nam",
            "latitude"        => "",
            "longitude"       => "",
            "phone"           => "+84-91-373-5036",
            "fax"             => "",
            "email"           => "",
            "website"         => "www.audivina.com",
            "services"        => "Headquarters",
            "hours"           => "",
            "instructions"    => "",
            'status'          => \app\models\User::STATUS_ACTIVE,
            'created_at'      => date("Y-m-d H:i:s"),
            'updated_at'      => date("Y-m-d H:i:s"),
            //'last_login'    => $this->datetime()
            "created_by"      => 1,
            "updated_by"      => 1,
        ]);
    }
    
    public function addDataTableTestimonial()
    {
        $this->insert('{{%testimonial}}', [
            'comment'  => "From our recent experience working with Auditiva, please be sure that we have been excited to work with the Auditiva team. Auditiva's personnel are high standard professionals, making the hearing aids business a pleasure.",
            'author'   => "Yannis Kontos, General Manager, Medicare I Kontos Ltd.",
            'location' => "Greece",
            'tags'     => "professionals",
            'status'   => \app\models\User::STATUS_ACTIVE,
        ]);
        $this->insert('{{%testimonial}}', [
            'comment'  => "Working as an Authorized Distributor of Auditiva for the last five years, I have been supported a lot from Auditiva's staff. They are not only professional individuals but also enthusiastic persons. You can ask their help whenever and whatever your need. Our company is bigger and bigger with them. Now I understand Auditiva's philosophy. Exceptional Quality and Customer Service is not just a way of doing business; it is really a way of their life, and it is the key to their success.",
            'author'   => "Long Thanh To MD, Audivina Advanced ENT and Hearing Center",
            'location' => "Vietnam",
            'tags'     => "professionals",
            'status'   => \app\models\User::STATUS_ACTIVE,
        ]);
    }
    
    public function addDataTableSetting()
    {
        $this->insert('{{%app_setting}}', [
           'key'      => 'FrontPage.Section1.Title',
           'value'    => 'For Consumers',
           'default'  => '',
           'status'   => '1',
           'type'     => '0',
           'unit'     => '0',
           'role'     => '0',
        ]);
        $this->insert('{{%app_setting}}', [
           'key'      => 'FrontPage.Section2.Title',
           'value'    => 'Our Products',
           'default'  => '',
           'status'   => '1',
           'type'     => '0',
           'unit'     => '0',
           'role'     => '0',
        ]);
        $this->insert('{{%app_setting}}', [
           'key'      => 'FrontPage.Section3.Title',
           'value'    => 'For Professionals',
           'default'  => '',
           'status'   => '1',
           'type'     => '0',
           'unit'     => '0',
           'role'     => '0',
        ]);
        $this->insert('{{%app_setting}}', [
           'key'      => 'FrontPage.Section1.Intro',
           'value'    => 'Available Treatment and Care',
           'default'  => '',
           'status'   => '1',
           'type'     => '0',
           'unit'     => '0',
           'role'     => '0',
        ]);
        $this->insert('{{%app_setting}}', [
           'key'      => 'FrontPage.Section2.Intro',
           'value'    => 'From Custom to Open Fit',
           'default'  => '',
           'status'   => '1',
           'type'     => '0',
           'unit'     => '0',
           'role'     => '0',
        ]);
        $this->insert('{{%app_setting}}', [
           'key'      => 'FrontPage.Section3.Intro',
           'value'    => 'Experience the Auditiva Difference',
           'default'  => '',
           'status'   => '1',
           'type'     => '0',
           'unit'     => '0',
           'role'     => '0',
        ]);
        
    }
    
    public function addDataTableUser()
    {
        $this->insert('{{%user}}', [
            'username'      => 'auditiva',
            'password_hash' => Yii::$app->security->generatePasswordHash('briza'),
            'auth_key'      => Yii::$app->security->generateRandomString(),
            'access_token'  => md5('auditiva-token'),
            'first_name'    => 'Guest',  
            'last_name'     => 'User', 
            'email'         => 'webmaster@auditiva.us',
            'phone'         => '',
            'role'          => \app\models\User::ROLE_REGISTERED,
            'status'        => \app\models\User::STATUS_ACTIVE,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
            //'last_login'    => $this->datetime()
        ]);
    }
}

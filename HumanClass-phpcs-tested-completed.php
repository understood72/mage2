<?php
/**
 *  HumanClass class file
 *   
 *  Php version 5.2
 *
 *  @category Human_Family_A
 *  @package  Human_Family_A
 *  @author   purencool <purencool@gmail.com>
 *  @license  http://opensource.org/licenses/GPL-3.0 GNU Public License
 *  @link     http://purencool.com
 * 
 */

/**
 *  HumanClass class
 * 
 *  The humanclass is an abstract class that 
 *  implies method on any class that extends it
 *
 * @category HumanClass
 * @package  HumanClass
 * @author   purencool <purencool@gmail.com>
 * @license  http://opensource.org/licenses/GPL-3.0 GNU General Public License
 * @link     http://www.hashbangcode.com/
 *
 */
abstract class HumanClass
{
    /**
     *  Any class that extends from the 
     *  humanClass needs to have a head 
     *  method 
     * 
     *  @return array()
     * 
     */
    abstract public function head ();
    
    /**
     *  Any class that extends from the 
     *  humanClass needs to have an arms 
     *  method  
     * 
     *  @return array()
     */
    abstract public function arms ();
    
    /**
     *  Any class that extends from the 
     *  humanClass needs to have a body
     *  method 
     * 
     *  @return array()
     */
    abstract public function body ();
    
    /**
     *  Any class that extends from the 
     *  humanClass needs to have a legs
     *  method 
     * 
     *  @return array()
     */
    abstract public function legs ();
}

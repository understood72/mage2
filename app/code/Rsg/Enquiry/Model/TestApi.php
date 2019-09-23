<?php 
namespace Rsg\Enquiry\Model;
/**
 * RSG Product Model.
 *
 * @method \Rsg\Enquiry\Model\ResourceModel\Product _getResource()
 * @method \Rsg\Enquiry\Model\ResourceModel\Product getResource()
 */
use \Rsg\Enquiry\Api\Data; 
class TestApi  implements TestApiInterface
{
    /**
     * Get ID.
     *
     * @return int
     */
    public function getId()
    {
        return 10;
    }
 
    /**
     * Set ID.
     *
     * @param int $id
     *
     * @return \Rsg\Enquiry\Api\Data\ProductInterface
     */
    public function setId($id)
    {
    }
 
    /**
     * Get title.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return 'this is test title';
    }
 
    /**
     * Set title.
     *
     * @param string $title
     *
     * @return \Rsg\Enquiry\Api\Data\ProductInterface
     */
    public function setTitle($title)
    {
    }
 
    /**
     * Get desc.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return 'this is test api description';
    }
 
    /**
     * Set Desc.
     *
     * @param string $desc
     *
     * @return \Rsg\Enquiry\Api\Data\ProductInterface
     */
    public function setDescription($desc)
    {
    }
}

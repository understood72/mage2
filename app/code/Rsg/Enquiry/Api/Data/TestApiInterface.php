<?php
namespace Rsg\Enquiry\Api\Data; 
interface TestApiInterface
{    
    const ENTITY_ID = 'entity_id'; 
    const TITLE = 'title'; 
    const DESC = 'description';
    /**
     * Get ID.
     *
     * @return int|null
     */
    public function getId();
 
    /**
     * Set ID.
     *
     * @param int $id
     *
     * @return \Rsg\Enquiry\Api\Data\ProductInterface
     */
    public function setId($id);
 
    /**
     * Get title.
     *
     * @return string|null
     */
    public function getTitle();
 
    /**
     * Set title.
     *
     * @param string $title
     *
     * @return \Rsg\Enquiry\Api\Data\ProductInterface
     */
    public function setTitle($title);
 
    /**
     * Get desc.
     *
     * @return string|null
     */
    public function getDescription();
 
    /**
     * Set Desc.
     *
     * @param string $desc
     *
     * @return \Rsg\Enquiry\Api\Data\ProductInterface
     */
    public function setDescription($desc);
}

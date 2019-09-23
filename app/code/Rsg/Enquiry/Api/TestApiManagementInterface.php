<?php 
namespace Rsg\Enquiry\Api;
 
interface TestApiManagementInterface
{
    /**
     * get test Api data.
     *
     * @api
     *
     * @param int $id
     *
     * @return \Rsg\Enquiry\Api\Data\TestApiInterface
     */
    public function getApiData($id);
}
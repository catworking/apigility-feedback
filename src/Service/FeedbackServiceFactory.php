<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:46:03
 */
namespace ApigilityFeedback\Service;

use Zend\ServiceManager\ServiceManager;

class FeedbackServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new FeedbackService($services);
    }
}
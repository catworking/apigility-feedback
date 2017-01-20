<?php
namespace ApigilityFeedback\V1\Rest\Feedback;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class FeedbackCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = FeedbackEntity::class;
}

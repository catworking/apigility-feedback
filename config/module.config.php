<?php
return [
    'service_manager' => [
        'factories' => [
            \ApigilityFeedback\V1\Rest\Feedback\FeedbackResource::class => \ApigilityFeedback\V1\Rest\Feedback\FeedbackResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'apigility-feedback.rest.feedback' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/feedback/feedback[/:feedback_id]',
                    'defaults' => [
                        'controller' => 'ApigilityFeedback\\V1\\Rest\\Feedback\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'apigility-feedback.rest.feedback',
        ],
    ],
    'zf-rest' => [
        'ApigilityFeedback\\V1\\Rest\\Feedback\\Controller' => [
            'listener' => \ApigilityFeedback\V1\Rest\Feedback\FeedbackResource::class,
            'route_name' => 'apigility-feedback.rest.feedback',
            'route_identifier_name' => 'feedback_id',
            'collection_name' => 'feedback',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'user_id',
                1 => 'status',
                2 => 'type',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityFeedback\V1\Rest\Feedback\FeedbackEntity::class,
            'collection_class' => \ApigilityFeedback\V1\Rest\Feedback\FeedbackCollection::class,
            'service_name' => 'Feedback',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'ApigilityFeedback\\V1\\Rest\\Feedback\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'ApigilityFeedback\\V1\\Rest\\Feedback\\Controller' => [
                0 => 'application/vnd.apigility-feedback.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'ApigilityFeedback\\V1\\Rest\\Feedback\\Controller' => [
                0 => 'application/vnd.apigility-feedback.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \ApigilityFeedback\V1\Rest\Feedback\FeedbackEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-feedback.rest.feedback',
                'route_identifier_name' => 'feedback_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityFeedback\V1\Rest\Feedback\FeedbackCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-feedback.rest.feedback',
                'route_identifier_name' => 'feedback_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'ApigilityFeedback\\V1\\Rest\\Feedback\\Controller' => [
            'input_filter' => 'ApigilityFeedback\\V1\\Rest\\Feedback\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'ApigilityFeedback\\V1\\Rest\\Feedback\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'attached_object_type',
                'description' => '捆绑的对象类型',
                'error_message' => '请输入捆绑的对象类型',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'field_type' => 'string',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'attached_object_id',
                'description' => '捆绑对象标识',
                'error_message' => '请输入捆绑对象标识',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'field_type' => 'string',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'status',
                'description' => '处理状态。
1待解决；2已解决。',
                'error_message' => '请输入处理状态',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'field_type' => 'int',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'type',
                'description' => '反馈类型',
                'error_message' => '请输入反馈类型',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'field_type' => 'string',
            ],
            4 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'article',
                'description' => '文章数据',
                'field_type' => 'json',
                'error_message' => '请输入文章数据',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'ApigilityFeedback\\V1\\Rest\\Feedback\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
];

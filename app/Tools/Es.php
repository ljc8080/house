<?php

namespace app\Tools;

use Elasticsearch\ClientBuilder;

class Es
{
    private $client;

    public function __construct($localhost = '127.0.0.1:9200')
    {
        $params = array(
            $localhost
        );
        $this->client = ClientBuilder::create()->setHosts($params)->build();
    }

    public function exists_index($index_name)
    {
        $params = [
            'index' => $index_name
        ];

        try {
            return $this->client->indices()->exists($params);
        } catch (\Elasticsearch\Common\Exceptions\BadRequest400Exception $e) {
            $msg = $e->getMessage();
            $msg = json_decode($msg, true);
            return $msg;
        }
    }

    /**
     * 删除索引
     * @param string $index_name
     * @return array
     */
    public function delete_index($index_name = 'test_ik')
    {
        $params = ['index' => $index_name];
        $response = $this->client->indices()->delete($params);
        return $response;
    }

    public function create_index($index_name)
    {
        if ($this->exists_index($index_name)) {
            return false;
        }
        $params = [
            // 索引名
            'index' => $index_name,
            'body' => [
                // 指定副本和分片
                'settings' => [
                    // 分片 后续不可修改
                    'number_of_shards' => 5,
                    // 副本后续可修改
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                    '_doc' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        // 字段
                        'properties' => [
                            'xiaoqu' => [
                                // 精确查询
                                'type' => 'keyword'
                            ],
                            'desn' => [
                                // 模糊搜索
                                'type' => 'text',
                                // 插件 中文分词插件  需要安装
                                'analyzer' => 'ik_max_word',
                                'search_analyzer' => 'ik_max_word'
                            ]
                        ],
                    ]
                ],
            ],
            'include_type_name' => true
        ];
        try {
            return $this->client->indices()->create($params);
        } catch (\Elasticsearch\Common\Exceptions\BadRequest400Exception $e) {
            $msg = $e->getMessage();
            $msg = json_decode($msg, true);
            return $msg;
        }
    }

    public function get_doc($id = 1, $index_name = 'test_ik', $type_name = 'goods')
    {
        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'id' => $id
        ];

        $response = $this->client->get($params);
        return $response;
    }

    /**
     * 更新文档
     * @param int $id
     * @param string $index_name
     * @param string $type_name
     * @param array $body ['doc' => ['title' => '苹果手机iPhoneX']]
     * @return array
     */
    public function update_doc($id = 1, $index_name = 'test_ik', $type_name = 'goods', $body = [])
    {
        // 可以灵活添加新字段,最好不要乱添加
        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'id' => $id,
            'body' => $body
        ];

        $response = $this->client->update($params);
        return $response;
    }

    /**
     * 删除文档
     * @param int $id
     * @param string $index_name
     * @param string $type_name
     * @return array
     */
    public function delete_doc($id = 1, $index_name = 'test_ik', $type_name = 'goods')
    {
        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'id' => $id
        ];

        $response = $this->client->delete($params);
        return $response;
    }

    public function search_doc($index_name, $column,$query)
    {
        if (!$index_name ||!$column|| !$query) return false;
        $params = [
            'index' => $index_name,
            'body' => [
                'query' => [
                    'match' => [
                        $column => [
                            'query' => $query
                        ]
                    ]
                ]
            ]
        ];

        $results = $this->client->search($params);
        return $results;
    }

    /**
     * 添加文档
     * @param $id
     * @param $doc ['id'=>100, 'title'=>'phone']
     * @param string $index_name
     * @param string $type_name
     * @return array
     */
    public function add_doc($id, $doc, $index_name = 'test_ik', $type_name = 'goods')
    {
        $params = [
            'index' => $index_name,
            'type' => $type_name,
            'id' => $id,
            'body' => $doc
        ];

        $response = $this->client->index($params);
        return $response;
    }
}

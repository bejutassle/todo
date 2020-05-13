<?php 

namespace App\Factory;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TaskList;

class Provider2Factory
{
    private $client;
    private $em;
    private $url_path;
    private $url_schema;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $em)
    {
        $this->client = $client;
        $this->em = $em;
        $this->url_path = 'http://www.mocky.io/v2/';
        $this->url_schema = '5d47f24c330000623fa3ebfa';
    }

    public function createList()
    {
        $client = $this->client->request('GET', "{$this->url_path}{$this->url_schema}");
        $content = json_decode($client->getContent(), true);

        $response = [];
        foreach ($content as $key => $value) {
          $task_id = (!empty(explode(' ', $value['id'][2]))) ? explode(' ', $value['id'])[2] : null;

          if(!array_key_exists($value['id'], $response)){
              $response[$key]['difficulty'] = $value['zorluk'];
              $response[$key]['duration'] = $value['sure'];
              $response[$key]['task_id'] = $task_id;
              $response[$key]['name'] = $value['id'];
          }else{
              $response[$key]['difficulty'] = $value['zorluk'];
              $response[$key]['duration'] = $value['sure'];
              $response[$key]['task_id'] = $task_id;
              $response[$key]['name'] = $value['id'];
          }
        }
      
        return $response;
    }

    public function saveList()
    {
        $client = $this->client->request('GET', "{$this->url_path}{$this->url_schema}");
        $content = json_decode($client->getContent(), true);
        $response = [];
        
        foreach ($content as $key => $value) {
          $task_id = (!empty(explode(' ', $value['id'][2]))) ? explode(' ', $value['id'])[2] : null;

          $task = new TaskList();
          $task->setTitle($value['id']);
          $task->setTaskId($task_id);
          $task->setLevel($value['zorluk']);
          $task->setEstimatedDuration($value['sure']);

          $this->em->persist($task);
          $this->em->flush();

        }
      
        return $response;
    }
}
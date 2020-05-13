<?php 

namespace App\Factory;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TaskList;

class Provider1Factory
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
		$this->url_schema = '5d47f235330000623fa3ebf7';
	}

    public function createList()
    {
    	$client = $this->client->request('GET', "{$this->url_path}{$this->url_schema}");
    	$content = json_decode($client->getContent(), true);

    	$response = [];
    	foreach ($content as $key => $value) {

    	  foreach ($value as $k => $v) {
    	  	$task_id = (!empty(explode(' ', $k[2]))) ? explode(' ', $k)[2] : null;

	          if(!array_key_exists($k, $response)){
	              $response[$key]['title'] = $k;
	              $response[$key]['task_id'] = $task_id;
	              $response[$key]['level'] = $v['level'];
	              $response[$key]['estimated_duration'] = $v['estimated_duration'];
	          }else{
	              $response[$key]['title'] = $k;
	              $response[$key]['task_id'] = $task_id;
	              $response[$key]['level'] = $v['level'];
	              $response[$key]['estimated_duration'] = $v['estimated_duration'];
	          }
    	  	
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

    	  foreach ($value as $k => $v) {
    	  	$task_id = (!empty(explode(' ', $k[2]))) ? explode(' ', $k)[2] : null;

    	  	$task = new TaskList();
	        $task->setTitle($k);
			$task->setTaskId($task_id);
			$task->setLevel($v['level']);
			$task->setEstimatedDuration($v['estimated_duration']);

	        $this->em->persist($task);
	        $this->em->flush();
    	  	
    	  }

    	}
    	
    	return $response;
    }
}
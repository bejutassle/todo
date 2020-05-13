<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\TaskList;

class IndexController extends AbstractController
{
    /**
     * @Route("/{slug}", name="index")
     */
    public function index($slug = 1)
    {

    	$db = $this->getDoctrine()->getManager();
	    $tasks = $db->createQuery("
	    	SELECT 
	    	T.id AS id, 
	    	T.title AS title, 
	    	T.task_id AS task_id,
	    	T.level AS level,
	    	T.estimated_duration AS estimated_duration,
	    	(T.estimated_duration * T.level) AS unit
	    	FROM App\Entity\TaskList AS T 
	    	ORDER BY
	    	unit
	    	ASC
    	")->getResult();

	    $sum = $db->createQuery("
	    	SELECT 
	    	SUM(T.estimated_duration * T.level) AS result
	    	FROM 
	    	App\Entity\TaskList
	    	AS 
	    	T 
    	")->getResult();

	    $sum = $sum[0]['result'];
    	$devs = $this->devs();
    	rsort($devs);

    	$unit = 0;
    	$weeks = [];
    	foreach ($devs as $k => $v) {
		$devs_weekly_capacity = array_sum(array_column($devs, 'weekly_capacity', 'weekly_capacity'));

    		foreach ($tasks as $key => $value) {
			$unit = $unit + $value['unit'];

	    		if($unit <= $devs_weekly_capacity){

	    			if($unit <= 45){
	    				$name = $devs[array_search(45, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 45 && $unit <= 90){
	    				$name = $devs[array_search(90, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 90 && $unit <= 135){
	    				$name = $devs[array_search(135, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 135 && $unit <= 180){
	    				$name = $devs[array_search(180, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 180 && $unit <= 225){
	    				$name = $devs[array_search(225, array_column($devs, 'weekly_capacity'))]['name'];
	    			}

		    		$weeks[$key]['id'] = $value['id'];
		    		$weeks[$key]['title'] = $value['title'];
		    		$weeks[$key]['level'] = $value['level'];
					$weeks[$key]['dev'] = $name;
					$weeks[$key]['estimated_duration'] = $value['estimated_duration'];
					$weeks[$key]['unit'] = $value['unit'];
					$weeks[$key]['total_unit'] = $unit;
					$weeks[$key]['week'] = 1;

				}elseif($unit > $devs_weekly_capacity && $unit <= $devs_weekly_capacity*2){

	    			if($unit <= 720 && $unit >= 675){
	    				$name = $devs[array_search(45, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 720 && $unit <= 765){
	    				$name = $devs[array_search(90, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 765 && $unit <= 810){
	    				$name = $devs[array_search(135, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 810 && $unit <= 855){
	    				$name = $devs[array_search(180, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 855 && $unit <= 900){
	    				$name = $devs[array_search(225, array_column($devs, 'weekly_capacity'))]['name'];
	    			}

		    		$weeks[$key]['id'] = $value['id'];
		    		$weeks[$key]['title'] = $value['title'];
		    		$weeks[$key]['level'] = $value['level'];
					$weeks[$key]['dev'] = $name;
					$weeks[$key]['estimated_duration'] = $value['estimated_duration'];
					$weeks[$key]['unit'] = $value['unit'];
					$weeks[$key]['total_unit'] = $unit;
					$weeks[$key]['week'] = 2;
				}elseif($unit > $devs_weekly_capacity*2 && $unit <= $devs_weekly_capacity*3){

	    			if($unit <= 1395 && $unit >= 1350){
	    				$name = $devs[array_search(45, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1440 && $unit <= 1350){
	    				$name = $devs[array_search(90, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1485 && $unit <= 1440){
	    				$name = $devs[array_search(135, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1530 && $unit <= 1485){
	    				$name = $devs[array_search(180, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1575 && $unit <= 1530){
	    				$name = $devs[array_search(225, array_column($devs, 'weekly_capacity'))]['name'];
	    			}

		    		$weeks[$key]['id'] = $value['id'];
		    		$weeks[$key]['title'] = $value['title'];
		    		$weeks[$key]['level'] = $value['level'];
					$weeks[$key]['dev'] = $name;
					$weeks[$key]['estimated_duration'] = $value['estimated_duration'];
					$weeks[$key]['unit'] = $value['unit'];
					$weeks[$key]['total_unit'] = $unit;
					$weeks[$key]['week'] = 3;
				}elseif($unit > $devs_weekly_capacity*3 && $unit <= $devs_weekly_capacity*4){

	    			if($unit <= 1575 && $unit >= 1530){
	    				$name = $devs[array_search(45, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1620 && $unit <= 1575){
	    				$name = $devs[array_search(90, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1665 && $unit <= 1620){
	    				$name = $devs[array_search(135, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1710 && $unit <= 1665){
	    				$name = $devs[array_search(180, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1755 && $unit <= 1710){
	    				$name = $devs[array_search(225, array_column($devs, 'weekly_capacity'))]['name'];
	    			}

		    		$weeks[$key]['id'] = $value['id'];
		    		$weeks[$key]['title'] = $value['title'];
		    		$weeks[$key]['level'] = $value['level'];
					$weeks[$key]['dev'] = $name;
					$weeks[$key]['estimated_duration'] = $value['estimated_duration'];
					$weeks[$key]['unit'] = $value['unit'];
					$weeks[$key]['total_unit'] = $unit;
					$weeks[$key]['week'] = 4;
				}elseif($unit > $devs_weekly_capacity*4 && $unit <= $sum){

	    			if($unit <= 1845 && $unit >= 1800){
	    				$name = $devs[array_search(45, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1890 && $unit <= 1845){
	    				$name = $devs[array_search(90, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1935 && $unit <= 1890){
	    				$name = $devs[array_search(135, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 1980 && $unit <= 1935){
	    				$name = $devs[array_search(180, array_column($devs, 'weekly_capacity'))]['name'];
	    			}elseif($unit > 2025 && $unit <= 1980){
	    				$name = $devs[array_search(225, array_column($devs, 'weekly_capacity'))]['name'];
	    			}

		    		$weeks[$key]['id'] = $value['id'];
		    		$weeks[$key]['title'] = $value['title'];
		    		$weeks[$key]['level'] = $value['level'];
					$weeks[$key]['dev'] = $name;
					$weeks[$key]['estimated_duration'] = $value['estimated_duration'];
					$weeks[$key]['unit'] = $value['unit'];
					$weeks[$key]['total_unit'] = $unit;
					$weeks[$key]['week'] = 5;
				}

    		}
    	}


    	array_multisort(array_column($weeks, 'id'), SORT_ASC, $weeks);
    	$weeks = $this->findArr($slug, $weeks, 'week');

    	$week_range_1 = (int)$sum;
    	$week_range_2 = array_sum(array_column($devs, 'weekly_capacity', 'weekly_capacity'));
    	$week_range = ($week_range_1 / $week_range_2);
    	$week_range = (int)number_format(round($week_range), 0);

        return $this->render('index/index.html.twig', [
        	'title' => 'Task Listesi',
        	'tasks' => $weeks,
        	'week' => $slug,
        	'week_range' => $week_range,
        ]);
    }

    /**
     * @Route("/view/{slug}", name="view")
     */
    public function view($slug = null)
    {

    	$task = $this->getDoctrine()
        ->getRepository(TaskList::class)
        ->find($slug);

	    if (!$task) {
	        throw $this->createNotFoundException(
	            'Geçersiz task!'
	        );
	    }

        return $this->render('index/view.html.twig', [
        	'title' => $task->getTitle(),
        	'task' => $task
        ]);
    }

    public function devs()
    {

    	return [
    		[
    			'id' => 1,
    			'name' => 'DEV1',
    			'level' => 1,
    			'weekly_capacity' => 45, 
    		],
    		[
    			'id' => 2,
    			'name' => 'DEV2',
    			'level' => 2,
    			'weekly_capacity' => 90, 
    		],
    		[
    			'id' => 3,
    			'name' => 'DEV3',
    			'level' => 3,
    			'weekly_capacity' => 135, 
    		],
    		[
    			'id' => 4,
    			'name' => 'DEV4',
    			'level' => 4,
    			'weekly_capacity' => 180, 
    		],
    		[
    			'id' => 5,
    			'name' => 'DEV5',
    			'level' => 5,
    			'weekly_capacity' => 225, 
    		],
    	];
    }

	public function findArr($var, array $arr, $col = null)
	{
		$ary = [];
		foreach ($arr as $item) {
		    if ($item[$col] == $var) {
		    	$ary[$item['id']]  = $item;
		    }
		}

		return $ary;
	}
}

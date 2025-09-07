<?php

include '../3party//vendor/autoload.php';
include '../shared/credential.php';
include '../shared/db.php';
include 'b.php';
$directory = "../shared/api";
foreach (array_diff(scandir($directory), array('..', '.')) as $ah) {
include($directory.'/'.$ah);
}

use Discord\WebSockets\Event;
use Discord\Builders\CommandBuilder;
use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Interactions\Command\Command; // Please note to use this correct namespace!
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Embed\Embed;
use Discord\Parts\User\Activity;
use Discord\Parts\OAuth\Application;
use Discord\Repository\Interaction\GlobalCommandRepository;
use function React\Async\async;

$botcolor="#7d5df4";
$discord = new Discord([
  'token' => $discord_botkey,
]);
$init_called = false;
$application_init_called = false;

function dialtodis($D,$C,$A,$B="") {
	global $botcolor;
	global $discord;
	$E=0;
	 $embed = new Embed($discord);
 $embed->setTitle($A)
                ->setType(Embed::TYPE_RICH)
                ->setColor($botcolor);
	foreach($C as $row){
if ($D) {
	if ($row['screenshot']==="No Screenshot"){
  $shot="No Screenshot";
	} else {
  $shot='https://api.novymap-qvh.top/api/staging/shot?id='.$row['id'];
	}

	
		$F = <<< AAAA
/dial $row[dial]		

$row[info]

-# ID:$row[id]
-# X:$row[x]
-# Y:$row[y]
-# Z:$row[z]
-# Add by:$row[addedby]
-# Screesnshot:$shot
-# Type:$row[marker_name]
AAAA;
	}else{
	$F = <<< AAAA
$row[info]
	
-# ID:$row[id]
-# Rail Name : $row[name]		
-# Add by:$row[addedby]
AAAA;
	}
		$embed ->addField([
                    'name' => $row['name'],
                    'value' => $F,
                    'inline' => true,
                ]);
		$E++;

}
if ($D) {
if($E===1){
	if (!($row['screenshot']==="No Screenshot")){
		$embed->setImage('https://api.novymap-qvh.top/api/staging/shot?id='.$row['id']);
	}
}
}
		if (!(empty($B))){$embed->setDescription($B.$E);}
		return($embed);
}
function websithandler (Interaction $interaction) {
		global $botcolor;

		global $discord;
		$sitearry=["https://map.novymap-qvh.top","https://api.novymap-qvh.top","https://www.novymap-qvh.top"];
	$site=' '.$sitearry[array_rand($sitearry)].' ';
//Ripped from novymap bot
$msg=websithandlermsg($site);

	 $embed = new Embed($discord);
            $embed->setTitle('website')
                ->setType(Embed::TYPE_RICH)
                ->setColor($botcolor)
                ->setImage('https://www.novymap-qvh.top/img/novymap-qvh.png')
                ->setDescription($msg[array_rand($msg)]);
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
}
function hatehandler (Interaction $interaction) {
	$hate=$interaction->data->name;
	if($hate==="roast"){
		$hatetilte="Roast";
		$hatetype="roasted";
	} else {
	$hatetilte="Blame";
		$hatetype="blamed";
	}
	global $conn;
	global $botcolor;

	 global $discord;
	  $reason = $interaction->data->options->offsetGet('reason')->value;
	$defal='<@'.$interaction->data->options->offsetGet('pigwin')->value.'> got '.$hatetype;
	$bcof="";
	if (!(empty($reason))){$bcof="|| Because of $reason ||";
}
$out=<<<AAAA
$defal

$bcof
AAAA;
	    $timestamp = date('Y-m-d H:i:s');
	$pigwin=mysqli_real_escape_string($conn,$interaction->data->options->offsetGet('pigwin')->value);
 $sql = "INSERT INTO `hate_stat` (`id`, `username`, `disid`, `timestamp`) VALUES (NULL, '','".$pigwin."','".$timestamp."' )";
	                $result = mysqli_query($conn, $sql);

	 $embed = new Embed($discord);
            $embed->setTitle($hatetilte)
                ->setType(Embed::TYPE_RICH)
                ->setColor($botcolor)
                ->setDescription($out);
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
}
$main = function (Discord $discord) {
$discord->application->commands->freshen()
        ->then(function (GlobalCommandRepository $gloabcmd) use (&$discord) {
    $command = new Command($discord, [
                'name' => 'info',
                'description' => 'Info',
                'options' => [
                    [
                        'name' => 'id',
                        'description' => 'ID',
                        'type' => Option::INTEGER,
                        'required' => true,
		    ]
		],
            ]);

	    $discord->application->commands->save($command);
 $command = new Command($discord, [
                'name' => 'info_railline',
                'description' => 'Info',
                'options' => [
                    [
                        'name' => 'id',
                        'description' => 'ID',
                        'type' => Option::INTEGER,
                        'required' => true,
		    ]
		],
            ]);

	    $discord->application->commands->save($command);

$command = new Command($discord, [
                'name' => 'search',
                'description' => 'Search Dial',
                'options' => [
                    [
                        'name' => 'query',
                        'description' => 'search',
                        'type' => Option::STRING,
                        'required' => true,
		    ],
 		[
                        'name' => 'amount',
                        'description' => 'search',
                        'type' => Option::INTEGER,
                        'required' => false,
		],
 		[
                        'name' => 'search_in',
                        'description' => 'search',
                        'type' => Option::STRING,
                        'required' => false,
		    ]

		],
            ]);

	    $discord->application->commands->save($command);
$command = new Command($discord, [
                'name' => 'cords',
                'description' => 'Search Dial by cords',
                'options' => [
                    [
                        'name' => 'x',
                        'description' => 'search',
                        'type' => Option::INTEGER,
                        'required' => true,
		    ],
 		[
                        'name' => 'z',
                        'description' => 'search',
                        'type' => Option::INTEGER,
                        'required' => true,
		],
 		[
                        'name' => 'radius',
                        'description' => 'search',
                        'type' => Option::INTEGER,
                        'required' => false,
		],
	[
                        'name' => 'amount',
                        'description' => 'search',
                        'type' => Option::INTEGER,
                        'required' => false,
		]
		],
            ]);

	    $discord->application->commands->save($command);
$command = new Command($discord, [
                'name' => 'search_railline',
                'description' => 'Search Dial by cords',
		'options' => 
		[

                    [
                        'name' => 'query',
                        'description' => 'search',
                        'type' => Option::STRING,
                        'required' => true,
		    ],

                	[
                        'name' => 'amount',
                        'description' => 'search',
                        'type' => Option::INTEGER,
                        'required' => false,
		]
		],
            ]);

	    $discord->application->commands->save($command);


$command = new Command($discord, [
                'name' => 'roast',
                'description' => 'roast',
                'options' => [
                    [
                        'name' => 'pigwin',
                        'description' => 'pigwin_',
                        'type' => Option::MENTIONABLE,
                        'required' => true,
			'autocomplete'=>'552492688381968397',
		    ],
  [
                        'name' => 'reason',
                        'description' => 'reason',
                        'type' => Option::STRING,
                        'required' => false,
		    ],

		],
            ]);

	    $discord->application->commands->save($command);

$command = new Command($discord, [
                'name' => 'blame',
                'description' => 'blame',
                'options' => [
                    [
                        'name' => 'pigwin',
                        'description' => 'pigwin_',
                        'type' => Option::MENTIONABLE,
                        'required' => true,
			'autocomplete'=>'552492688381968397',
		    ],
		  [
                        'name' => 'reason',
                        'description' => 'reason',
                        'type' => Option::STRING,
                        'required' => false,
		    ],

		],
            ]);

	    $discord->application->commands->save($command);

$command = new Command($discord, [
                'name' => 'about',
                'description' => 'about',
            ]);

	    $discord->application->commands->save($command);

$command = new Command($discord, [
                'name' => 'ping',
                'description' => 'pong',
		
]);
	    $discord->application->commands->save($command);
$command = new Command($discord, [
                'name' => 'website',
                'description' => 'offical website',
		
]);

	    $discord->application->commands->save($command);
$command = new Command($discord, [
                'name' => 'site',
                'description' => 'offical website',
		
]);

	    $discord->application->commands->save($command);

$discord->listenCommand('info', function (Interaction $interaction) {
	  $ID = intval($interaction->data->options->offsetGet('id')->value);

	 global $conn;
$result = api_info($conn, $ID);
$tmp=[0=>$result['data']];
	 $embed=dialtodis(true,$tmp,'Info');
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});

$discord->listenCommand('info_railline', function (Interaction $interaction) {
	  $ID = intval($interaction->data->options->offsetGet('id')->value);

	 global $conn;
$result = api_info_railline($conn, $ID);
$tmp=[0=>$result['data']];
	 $embed=dialtodis(false,$tmp,'Info');
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});

$discord->listenCommand('search', function (Interaction $interaction) {
	  $q = $interaction->data->options->offsetGet('query')->value;
	  $a = intval($interaction->data->options->offsetGet('amount')->value);
	  $w = intval($interaction->data->options->offsetGet('search_in')->value);
if(empty($a) or ($a > 25) or ($a < 0)){
	  $a=10;
	  }
	  


	 global $conn;
$result = api_search($conn, $q,$a,$w,0);
	 $embed=dialtodis(true,$result['data'],'Search','Found Dial :');
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});
$discord->listenCommand('cords', function (Interaction $interaction) {
	  $x = intval($interaction->data->options->offsetGet('x')->value);
	  $z = intval($interaction->data->options->offsetGet('z')->value);
	  $r = intval($interaction->data->options->offsetGet('radius')->value);
	  $a = intval($interaction->data->options->offsetGet('amount')->value);
	  if(empty($r)){
		  $r=256;
	  }
	  if(empty($a) or ($a > 25) or ($a < 0)){
	  $a=25;
	  }
	 global $conn;
$result = api_cords($conn, $x,$z,$r,$a,0);
	 $embed=dialtodis(true,$result['data'],'Coords','Found Dial :');
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});
$discord->listenCommand('search_railline', function (Interaction $interaction) {
	  $q = $interaction->data->options->offsetGet('query')->value;
	  $a = intval($interaction->data->options->offsetGet('amount')->value);
	  if(empty($a) or ($a > 25) or ($a < 0)){
	  $a=25;
	  }
	 global $conn;
$result = api_search_railline($conn, $q,$a);
	 $embed=dialtodis(false,$result['data'],'Lines','Found Line :');
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});

$discord->listenCommand('ping', function (Interaction $interaction) use (&$discord) {
$discord->updatePresence(null,false,'online',false);
	global $botcolor;
	 $embed = new Embed($discord);
            $embed->setTitle('Ping')
                ->setType(Embed::TYPE_RICH)
                ->setColor($botcolor)
                ->setImage('https://www.novymap-qvh.top/img/novymap-qvh.png')
                ->setDescription('I am alive :3');
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});


$discord->listenCommand('roast', function (Interaction $interaction) {hatehandler ($interaction);});
$discord->listenCommand('blame', function (Interaction $interaction) {hatehandler ($interaction);});

$discord->listenCommand('about', function (Interaction $interaction) {
	global $botcolor;

	 global $discord;
	 $embed = new Embed($discord);
	 $A=<<<AAAA
Officaly discord bot of [novymap-qvh](https://www.novymap-qvh.top/).

-# Proudly powered by [DiscordPHP](https://github.com/discord-php/DiscordPHP)

||Who need javascript,python for discord bot when you have PHP :3||
AAAA;

            $embed->setTitle('About')
                ->setType(Embed::TYPE_RICH)
                ->setColor($botcolor)
                ->setImage('https://www.novymap-qvh.top/img/novymap-qvh.png')
                ->setDescription($A);
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});

$discord->listenCommand('website',function (Interaction $interaction) {websithandler($interaction);});
$discord->listenCommand('site',function (Interaction $interaction) {websithandler($interaction);});

});
};

$discord->once('init', function (Discord $discord) use (&$init_called, &$application_init_called, &$main) {
    $init_called = true;
    if (! $application_init_called) {
        return;
    }
    $main($discord);
    unset($main, $init_called, $application_init_called);
});
$discord->once('application-init', function (Discord $discord) use (&$init_called, &$application_init_called, &$main) {
    $application_init_called = true;
    if (! $init_called) {
        return;
    }
    $main($discord);
    unset($main, $init_called, $application_init_called);
});
$discord->on(
    Event::INTERACTION_CREATE,
    function (Interaction $interaction) {
		    global $conn;
	    if ($interaction->type === Interaction::TYPE_APPLICATION_COMMAND) {
	    $timestamp = date('Y-m-d H:i:s');
	$cmd=mysqli_real_escape_string($conn,$interaction->data->name);
 $sql = "INSERT INTO `dis_stat`(`id`, `cmd`, `timestamp`) VALUES (NULL,'".$cmd."','".$timestamp."' )";
	                $result = mysqli_query($conn, $sql);

	    }
    });
$discord->run();


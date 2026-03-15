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
use Discord\Parts\Interactions\Command\Command;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Embed\Embed;
use Discord\Parts\User\Activity;
use Discord\Parts\User\User;
use Discord\Parts\OAuth\Application;
use Discord\Repository\Interaction\GlobalCommandRepository;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Formatter\HtmlFormatter;
use Monolog\Handler\StreamHandler;
$streamHandler = new StreamHandler('/var/log/novydiscordbot/log', Level::Info);
//$streamHandler = new StreamHandler('/srv/http/novy/discord/log', Level::Debug);
$streamHandler->setFormatter(new HtmlFormatter());
$logger = new Logger('Novymap-qvh', [$streamHandler]);
$botcolor="#7d5df4";
$discord = new Discord([
    'logger' => $logger,
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
  $shot='https://novyapi.daktoinc.co.uk/api/staging/shot?id='.$row['id'];
	}

	
		$F = <<< AAAA
/dial $row[dial]		
$row[info]
-# ID:$row[id]
-# X:$row[x]
-# Y:$row[y]
-# Z:$row[z]
-# Wiki:$row[wiki]
-# Add by:$row[addedby]
-# Screesnshot:$shot
-# Type:$row[marker_name]
AAAA;
	}else{
	$F = <<< AAAA
$row[info]
-# ID:$row[id]
-# Rail Name : $row[name]		
-# Wiki:$row[wiki]
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
		$embed->setImage('https://novyapi.daktoinc.co.uk/api/staging/shot?id='.$row['id']);
	}
}
}
		if (!(empty($B))){$embed->setDescription($B.$E);}
		return($embed);
}
function websithandler (Interaction $interaction) {
		global $botcolor;

		global $discord;
		$sitearry=["https://map.novymap-qvh.top","https://novyapi.daktoinc.co.uk","https://www.novymap-qvh.top"];
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

function disusername ($user) {
if ($user['discriminator']==="0"){
return($user['username']);
}else{
return($user['username'] . '#' . $user['discriminator']);
}
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
$conn=reconnectdb($conn);
	 $embed = new Embed($discord);
 $timestamp = date('Y-m-d H:i:s');
	$pigwinid =$interaction->data->options->offsetGet('pigwin')->value;
	$pigwin =$interaction->data->resolved->users->first();
if (isset($pigwin['username'])){
	$pingsign='!';

$pigwinname=mysqli_real_escape_string($conn,disusername($pigwin));

$sql = "INSERT INTO `hate_stat` (`id`, `username`, `timestamp`) VALUES (NULL, '$pigwinname','$timestamp')";
	                $result = mysqli_query($conn, $sql);

$embed->setImage(str_replace("webp","png",$pigwin['avatar']));
}else{
	$pingsign='&';
}
	$out='<@'.$pingsign.$pigwinid.'> got '.$hatetype;
	$reason = $interaction->data->options->offsetGet('reason')->value ?? '';
	if (!(empty($reason))){$out.=PHP_EOL."|| Because of $reason ||";}
 
            $embed->setTitle($hatetilte)
                ->setType(Embed::TYPE_RICH)
                ->setColor($botcolor)
                ->setDescription($out);
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
}
function newcmd (&$discord,&$commands,$cmdarry) {
	if ($command = $commands->get('name', $cmdarry['name'])) {
	//		$commands->delete($command);
	} else {
	$cmdarry['contexts']=[
            Interaction::CONTEXT_TYPE_GUILD,
            Interaction::CONTEXT_TYPE_BOT_DM,
            Interaction::CONTEXT_TYPE_PRIVATE_CHANNEL,
        ];
    $command = new Command($discord,$cmdarry); 

	    $commands->save($command);
}
}
$main = function (Discord $discord) {
$discord->application->commands->freshen()
        ->then(function (GlobalCommandRepository $commands) use (&$discord) {

newcmd ($discord,$commands, [
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

newcmd ($discord,$commands, [
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


newcmd ($discord,$commands, [
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

newcmd ($discord,$commands, [
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

newcmd ($discord,$commands, [
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


newcmd ($discord,$commands, [
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


newcmd ($discord,$commands, [
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


newcmd ($discord,$commands, [
                'name' => 'about',
                'description' => 'about',
            ]);


newcmd ($discord,$commands, [
                'name' => 'ping',
                'description' => 'pong',
		
]);

newcmd ($discord,$commands, [
                'name' => 'phprock',
                'description' => 'php!!!',
		
]);

newcmd ($discord,$commands, [
                'name' => 'website',
                'description' => 'offical website',
		
]);

newcmd ($discord,$commands, [
                'name' => 'site',
                'description' => 'offical website',
		
]);

newcmd ($discord,$commands, [
                'name' => 'whoami',
                'description' => 'Who am i?',
		
]);

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
	global $botcolor;
	 $embed = new Embed($discord);
            $embed->setTitle('Ping')
                ->setType(Embed::TYPE_RICH)
                ->setColor($botcolor)
                ->setImage('https://www.novymap-qvh.top/img/novymap-qvh.png')
                ->setDescription('I am alive :3');
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});

$discord->listenCommand('whoami', function (Interaction $interaction) use (&$discord) {
	global $botcolor;
	$user=$interaction->user;
	$out="Your username : ".disusername($user).PHP_EOL;
	if(!empty($user['global_name'])){
	$out.="Your display name : ".$user['global_name'].PHP_EOL;
	} 
	$out.="You speak : ".$interaction->locale;

	 $embed = new Embed($discord);
            $embed->setTitle('I know who are you')
                ->setType(Embed::TYPE_RICH)
                ->setColor($botcolor)
		->setImage(str_replace("webp","png",$user['avatar']))
                ->setDescription($out);
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});

$discord->listenCommand('phprock', function (Interaction $interaction) use (&$discord) {
	global $botcolor;
	 $embed = new Embed($discord);
            $embed->setTitle('php!!! It rocks.')
                ->setType(Embed::TYPE_RICH)
                ->setColor($botcolor)
                ->setImage('https://upload.wikimedia.org/wikipedia/commons/thumb/3/31/Webysther_20160423_-_Elephpant.svg/2560px-Webysther_20160423_-_Elephpant.svg.png')
                ->setDescription('BTW https://php.rocks/ is avery cool site');
                          $interaction->respondWithMessage(MessageBuilder::new()->addEmbed($embed));
});


$discord->listenCommand('roast',function (Interaction $interaction) {hatehandler($interaction);});
$discord->listenCommand('blame',function (Interaction $interaction) {hatehandler($interaction);});

$discord->listenCommand('about', function (Interaction $interaction) {
	global $botcolor;

	 global $discord;
	 $embed = new Embed($discord);
	 $A=<<<AAAA
Officaly discord bot of [novymap-qvh](https://www.novymap-qvh.top/).
-# Proudly powered by [DiscordPHP](https://github.com/discord-php/DiscordPHP)
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
$discord->updatePresence(null,false,'online',false);
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
$conn=reconnectdb($conn);
	    if ($interaction->type === Interaction::TYPE_APPLICATION_COMMAND) {
	    $timestamp = date('Y-m-d H:i:s');
	$lang=mysqli_real_escape_string($conn,$interaction->locale);
	$cmd=mysqli_real_escape_string($conn,$interaction->data->name);
 $sql = "INSERT INTO `dis_stat`(`id`, `cmd`, `timestamp`,`lang`) VALUES (NULL,'".$cmd."','".$timestamp."','".$lang."' )";
	                $result = mysqli_query($conn, $sql);

	    }
    });
$discord->run();


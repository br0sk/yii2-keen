# yii2-keen
A Yii2 extension for http://keen.io

This is an extension for Yii2 that makes it easy to use http://keen.io/.



You can configure it in your application configuration like so:

	'keenio' => [
		'class' => 'br0sk\keenio\KeenIo',
		'projectId' => 'yourprojectid',
		'readKey' 	=> 'yourreadkey',
		'writeKey'	=> 'yourwritekey'
	],
	
**note:** You can find the project id and push API key in the control panel for you project if you log in [here](https://keen.io).

Adding it to your `components` array.

Pushing an event is as easy as:

	$event = ['purchase' => ['item' => 'Golden Elephant']];
	$keenReturn = Yii::$app->keenio->addEvent('purchases', $event);
    
You can now use all the calls in the [Keen PHP SDK](https://github.com/keenlabs/KeenClient-PHP) this extension builds on 


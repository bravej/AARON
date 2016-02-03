<?php
	
	class CTwitter{	
		
		private $screen_name;//nom avec @ -> ex: @MrAntoineDaniel
		
		function __construct($screen_name){
			$this->screen_name = $screen_name;
						
		}
		
		public function afficher(){
			
			include('TwitterTextFormatter.php');
			include('TwitterAPIExchange.php');

			//twitter application tokens
			$settings = array(
				'consumer_key' => 'X3CFmg15tOhI9Y7H0cGP3ylxX',
				'consumer_secret' => 'I7gwqLDH9JnEAMlKGchzWzEaWVy3vUNDYM2kQQsk2ENqeWmmvG',

				'oauth_access_token' => '3308186359-BUBd8phkNBNlT2JU8lnFctrlThCgrvJHGtDOZaL',
				'oauth_access_token_secret' => 'pvSoe3K38JpiQqChz2DItL7NDwsO8alRuz5xnv9QOFU1Y',
			);

			//timeline
			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$getfield = "?screen_name={$this->screen_name}";
			$requestMethod = 'GET';

			$twitter = new TwitterAPIExchange($settings);
			$user_timeline = $twitter
			  ->setGetfield($getfield)
			  ->buildOauth($url, $requestMethod)
			  ->performRequest();

			$user_timeline = json_decode($user_timeline);
			$msg = ""; 
			
			if (isset($user_timeline[1]->user->profile_image_url)) {
				$media_url = $user_timeline[1]->user->profile_image_url;
				$msg .=  "<img src='{$media_url}' width='10%' /> ". $user_timeline[1]->user->name . " @". $user_timeline[1]->user->screen_name ;
			}
			
			$msg .=  "<hr />";

			foreach ($user_timeline as $user_tweet) {
				
			   $msg .= TwitterTextFormatter::format_text($user_tweet) . "<br/>";
				
			if (isset($user_tweet->entities->media)) {
				$media_url = $user_tweet->entities->media[0]->media_url;
				$msg.= "<img src='{$media_url}' width='50%' />";
			}
							
			  $msg.= "<hr />";
			}
			return $msg;
		}
		
		public function sauvegarde($id){
			try {
				$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
			} catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}
			$stmt = $dbh->prepare('INSERT INTO Twitter(ID, twitter) VALUES(:ID, :twitter)') or exit(print_r($bdd->errorInfo()));
			$stmt->bindParam(':ID', $id);
			$stmt->bindParam(':twitter', $this->screen_name);
			$stmt->execute();
		}
                
                public function supprimer($id){
			try {
				$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
			} catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}
			
			$stmt = $dbh->prepare('DELETE FROM Twitter WHERE ID LIKE :ID AND twitter LIKE :twitter') or exit(print_r($bdd->errorInfo()));
			$stmt->bindParam(':ID', $id);
			$stmt->bindParam(':twitter', $this->screen_name);
			$stmt->execute();
		}
	}
?>
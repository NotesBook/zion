<?php
/**
 * NotesBook Http Engine Service
 *
 * @author     Nombre <email@email.com>
 * @package    \application\config
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 * 
 * Http Engine Service
 * ###############
 * Get Data from http request, or set http response
 * 
 * Content
 * #######
 * PHPMailer. More info http://phpmailer.worxware.com/?pg=examplebgmail
 * 
 * 
 * 
 * 
 */

/** Load Dependecies
*/

/** Class Definition
*/

class MailEngineService {

	private static $phpMailerObj;

	private static function set_up() {

		global $_NB_GLOBALS;

		require('lib/phpmailer/PHPMailerAutoload.php');
		self::$phpMailerObj = new PHPMailer;
		self::$phpMailerObj->CharSet = 'UTF-8';
		self::$phpMailerObj->IsSMTP(); // enable SMTP
		self::$phpMailerObj->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
		self::$phpMailerObj->SMTPAuth = true; // authentication enabled
		self::$phpMailerObj->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
		self::$phpMailerObj->Host = "smtp.gmail.com";
		self::$phpMailerObj->Port = 587; // or 587
		self::$phpMailerObj->IsHTML(true);
		self::$phpMailerObj->Username = $_NB_GLOBALS["settings"]->email->user;
		self::$phpMailerObj->Password = $_NB_GLOBALS["settings"]->email->pass;

		self::$phpMailerObj->SetFrom($_NB_GLOBALS["settings"]->email->user, "Equipo de Notesbook");

	}

	public static function send($subject, $body, $to) {

		try {

			if(is_null(self::$phpMailerObj)) {

				self::set_up();

			}

			self::$phpMailerObj->AddAddress($to);
			self::$phpMailerObj->Subject = $subject;
			self::$phpMailerObj->MsgHTML($body);

			if(!self::$phpMailerObj->send()) {
				
				throw new Exception("PhpMailerException: Error Sending email: '".self::$phpMailerObj->ErrorInfo."'");

			}

		} catch (phpmailerException $e) {

		  	throw $e; //Pretty error messages from PHPMailer

		} catch (Exception $e) {

			throw new Exception("MailEngineServiceException: ".$e->getMessage());

		}

	}

}
 ?>


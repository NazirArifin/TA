<?php
/**
 * Controller helper
 * Dipanggil dari file Loader.php untuk persiapan file config/controller.php
 */

// ----------------------------------------------------------------
/**
 * Halt app dengan header 400 (Bad Request)
 */
function halt400($app) {
	$app->halt(400);
	$app->stop();
}
 
/**
 * Halt app dengan header 401 (Unauthorized)
 */
function halt401($app) {
	$app->halt(401);
	$app->stop();
}

/**
 * Halt app dengan header 403 (Forbidden)
 */
function halt403($app) {
	$app->halt(403);
	$app->stop();
}

/**
 * Halt app dengan header 404 (Not Found)
 */
function halt404($app) {
	$app->halt(404);
	$app->stop();
}

/**
 * Cek token
 */
function validate_token(&$ctr, $token = '') {
	$ctr->load('file', 'lib/JWT.php');
	$ctr->load('helper', 'date');
	if (empty($token)) return $ctr->MainModel->validate_token();
	else return $ctr->MainModel->validate_token($token);
}

/**
 * Save token
 */
function save_token($token, $exp) {
	// set cookies
	setcookie('token', $token, $exp, '/', '', ( ! empty($_SERVER['HTTPS'])), TRUE);
}

/**
 * Delete token
 */
function delete_token(&$ctr) {
	$ctr->load('file', 'lib/JWT.php');
	$ctr->load('model', 'main');
	$ctr->MainModel->member_signout($_COOKIE['token']);
	setcookie('token', "", time() - 3600);
}

/**
 * Cek token
 */
function cek_token(&$ctr) {
	if ( ! isset($_COOKIE['token'])) return FALSE;
	else {
		$ctr->load('file', 'lib/JWT.php');
		$ctr->load('helper', 'date');
		$ctr->load('model', 'main');
		// hapus cookie token jika tidak valid
		if ($ctr->MainModel->validate_token($_COOKIE['token']) === FALSE) {
			delete_token($ctr);
			return FALSE;
		} else {
			// tambah waktu expiration cookie
			$exp = time() + (5 * 24 * 3600);
			save_token($_COOKIE['token'], $exp);
			return TRUE;
		}
	}
}

/**
 * Redirect ke home
 */
function redirect_home($message = '') {
	header('Location: /home' . ( ! empty($message) ? '?pesan=' . $message : ''));
	exit;
}

/**
 * Redirect ke root
 */
function redirect_index($message = '') {
	header('Location: /' . ( ! empty($message) ? '?pesan=' . $message : ''));
	exit;
}
 
// ----------------------------------------------------------------
/**
 * Header json
 */
function json_output($app, $data) {
	$app->contentType('application/json');
	echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
}
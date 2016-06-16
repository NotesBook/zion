<?php

	require_once('../preheader.php'); // <-- this include file MUST go first before any HTML/output
	include ('../ajaxCRUD.class.php'); // <-- this include file MUST go first before any HTML/output
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
<?php
    $tblDemo = new ajaxCRUD("Item", "users", "id", "../");
    $tblDemo->omitPrimaryKey();

    $tblDemo->setLimit(5);
    $tblDemo->addAjaxFilterBox('name');
    $tblDemo->addAjaxFilterBox('surname');
	$tblDemo->formatFieldWithFunction('name', 'makeBlue');
	$tblDemo->formatFieldWithFunction('surname', 'makeBlue');
	echo "<h2>Usuarios</h2>\n";
	$tblDemo->showTable();

	echo "<br /><hr ><br />\n";

    $tblDemo = new ajaxCRUD("Item", "classrooms", "id", "../");
    $tblDemo->omitPrimaryKey();

    $tblDemo->setLimit(5);
    $tblDemo->addAjaxFilterBox('name');
    $tblDemo->formatFieldWithFunction('name', 'makeBlue');
    echo "<h2>Clases</h2>\n";
    $tblDemo->showTable();

    echo "<br /><hr ><br />\n";

    $tblDemo = new ajaxCRUD("Item", "classrooms_users", "id", "../");

    $tblDemo->setLimit(5);
    echo "<h2>Usuarios Clases</h2>\n";
    $tblDemo->showTable();

    echo "<br /><hr ><br />\n";

    $tblDemo = new ajaxCRUD("Item", "articles", "id", "../");
    $tblDemo->omitPrimaryKey();

    $tblDemo->setLimit(5);
    $tblDemo->addAjaxFilterBox('title');
    $tblDemo->formatFieldWithFunction('title', 'makeBlue');
    echo "<h2>Artículos</h2>\n";
    $tblDemo->showTable();

    echo "<br /><hr ><br />\n";

    $tblDemo = new ajaxCRUD("Item", "articles_likes", "id", "../");

    $tblDemo->setLimit(5);
    $tblDemo->addAjaxFilterBox('article_id');
    $tblDemo->addAjaxFilterBox('user_id');
    echo "<h2>Artículos - Megusta</h2>\n";
    $tblDemo->showTable();

	function makeBold($val){
		return "<b>$val</b>";
	}

	function makeBlue($val){
		return "<span style='color: blue;'>$val</span>";
	}

?>
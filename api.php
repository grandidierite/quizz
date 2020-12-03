<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'test';

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("Database connection failed");

function startQuiz($conn)
{
	$quesList = array();
	$quesListQuery = mysqli_query($conn,"SELECT * FROM quiz ORDER BY RAND() LIMIT 10");
	while($quesListQueryFetch = mysqli_fetch_assoc($quesListQuery))
	{
		$quesList[] = $quesListQueryFetch;
	}
	return $quesList;
}

function getAnswerById($conn, $id)
{
	$result = mysqli_query($conn,"SELECT answer FROM quiz WHERE id=$id");
	$answer = $result->fetch_row()[0];
	return $answer;
}

function getImagePathById($conn, $id)
{
	$result = mysqli_query($conn,"SELECT image_path FROM quiz WHERE id=$id");
	$answer = $result->fetch_row()[0];
	return $answer;
}
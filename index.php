<?php
	include 'api.php';

	$quesList = startQuiz($conn);
	//var_dump($quesList);
	$totalques = count($quesList);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="bootstrap-4.5.3/css/bootstrap.min.css">
	<script src="jquery-3.5.1.min.js"></script>
	<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script src="bootstrap-4.5.3/js/bootstrap.min.js"></script>
	<style>
		body {
			background-image: url('images/background.jpg');
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-position: center;
			background-size: cover;
		}
		.vertical-center {
			min-height: 90vh;
			display: flex;
			align-items: center;
		}
		.srcimg, .dstimg, .solimg {
			display: inline-block;
		}
		.dstimg {
			border: solid black 1px;
		}
		.solimg {
			border: solid #28a745 1px;
			margin-left: 2px;
		}
		
		.form-inline {  
			display: flex;
			flex-flow: row wrap;
			justify-content: center;
			align-items: center;
		}

		.form-inline label {
			margin: 5px 10px 5px 0;
		}

		.form-inline input {
			vertical-align: middle;
			margin: 5px 10px 5px 0;
			padding: 10px;
			background-color: #fff;
			border: 1px solid #ddd;
		}
	</style>
</head>
<body>
<div class="vertical-center">
	<div class="container">
		<div class="row my-5">
			<div class="col-md-10 mx-auto">
				<div id="slide1" class="slides">
				    <div class="card border-primary mb-3">
				  		<div class="card-body">
					    	<div class="card-text text-center">
					    		<h1>Quiz</h1>
					    		<div class="form-inline mt-5">
					    			<label for="user">Name:</label>
  									<input type="text" id="user" placeholder="Enter Name" name="user">
					    		</div>
								<button class="btn btn-outline-info btn-lg my-3 next" data-page="1">START</button>
					    	</div>
					  	</div>
					</div>
				</div>
				<?php $i=1; foreach ($quesList as $ques): ?>
				<?php $percent=intval((($i-1)*100)/$totalques); ?>
				<div id="slide<?php echo $i+1; ?>" class="slides">
					<p class="lead" style="font-weight:bold;color:white;">Complete <?php echo $percent; ?>% (<?php echo $i-1; ?> of <?php echo $totalques ?>)</p>
				  	<div class="progress mb-5">
						<div class="progress-bar bg-success" role="progressbar" style="width:<?php echo $percent; ?>%" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				    <div class="card border-primary mb-3">
					  	<div class="card-header">Problem <?php echo $i; ?> <span class="score text-info float-right">Your Score: 0</span></div>
				  		<div class="card-body">
				  			<div id="sign<?php echo $i; ?>"></div>
				  			<!--<p class="text-success text-center" style="font-size:24px;font-weight:bold;">&#10004; CORRECT</p>
				  			<p class="text-danger text-center" style="font-size:24px;font-weight:bold;">&#10060; WRONG</p>-->
					    	<div class="card-text mb-5">
					    		<p><?php echo $ques['question']; ?></p>
					    		
					    		<?php if(isset($ques['images']) && !is_null($ques['images'])): ?>
					    		<?php $imgs = explode("$$", $ques['images']); ?>
				    			<div class="src text-center mb-3">
				    				<?php foreach ($imgs as $img): ?>
					    			<img src="<?php echo $ques['image_path'].'/'.$img; ?>" class="srcimg srcimg<?php echo $i ?>">
					    			<?php endforeach; ?>
				    			</div>
				    			<?php endif; ?>
					    		
					    		<?php if($ques['question_type'] === 'dragndrop'): ?>
					    		<?php $ans = explode("$$", $ques['answer']); ?>
					    		<?php $countans = count($ans); ?>
					    		<div class="dst text-center">
					    			<?php for ($x = 0; $x < $countans; $x++): ?>
					    			<img src="images/blank.jpg" class="dstimg <?php echo 'answer'.($i); ?>">
					    			<?php endfor; ?>
				    			</div>
				    			<?php endif; ?>

				    			<?php if($ques['question_type'] === 'text'): ?>
				    				<div class="form-text" ><input type="text" name="<?php echo 'answer'.($i); ?>" class="form-text-input" placeholder="Answer"></div>
								<?php endif; ?>

								<?php if($ques['question_type'] === 'single'): ?>
									<?php $options = explode("$$", $ques['options']); ?>
									<?php foreach ($options as $value): ?>
				    				<div class="form-check">
										<label><input class="form-check-input" name="<?php echo 'answer'.($i); ?>" type="radio" value="<?php echo $value; ?>"><?php echo $value; ?></label>
									</div>
									<?php endforeach; ?>
								<?php endif; ?>

								<?php if($ques['question_type'] === 'multiple'): ?>
									<?php $options = explode("$$", $ques['options']); ?>
									<?php foreach ($options as $value): ?>
				    				<div class="form-check">
										<label><input class="form-check-input" name="<?php echo 'answer'.($i); ?>" type="checkbox" value="<?php echo $value; ?>"><?php echo $value; ?></label>
									</div>
									<?php endforeach; ?>
								<?php endif; ?>		

								<div class="text-success text-center mt-5 d-none" id="solution<?php echo $i; ?>" style="font-size:20px;font-weight:bold;"></div>		    				
					    	</div>
					    	<div class="text-center">
					    		<?php if($ques['question_type'] === 'dragndrop'): ?>
					    		<button id="rst<?php echo $i; ?>" class="btn btn-primary reset mx-auto" data-problem="<?php echo $i; ?>">Reset</button>
				    			<?php endif; ?>
					    		<button id="sbt<?php echo $i; ?>" class="btn btn-primary submit mx-auto" data-id="<?php echo $ques['id']; ?>" data-problem="<?php echo $i; ?>" data-problem-type="<?php echo $ques['question_type']; ?>" data-button="<?php echo $i === $totalques ? 'finish' : 'next' ?>">Submit</button>
					    		<!--<button class="btn btn-primary" data-page="<?php //echo $i+1; ?>">Next</button>-->
					    	</div>
					  	</div>
					</div>
					<div class="clearfix">
						<!--<button class="btn btn-secondary previous" data-page="1">Previous</button>-->
	    				
	    			</div>
				</div>
				<?php $i++; endforeach; ?>
				<div id="slide<?php echo $i+1; ?>" class="slides">
				    <div class="card border-primary mb-3">
				  		<div class="card-body">
					    	<div class="card-text text-center">
					    		<p style="font-size:30px;">You have reached the end of the quiz</p>
					    		<p style="font-size:20px;">Correct : <span id="correct"></span></p>
					    		<p style="font-size:20px;">Wrong : <span id="wrong"></span></p>
								<button class="btn btn-outline-info btn-lg retake my-3" data-page="1">Retake Quiz</button>
					    	</div>
					  	</div>
					</div>
				</div>
				<!--<div id="question2" class="problems">
					<p class="lead" style="font-weight:bold;color:white;">Complete 10%</p>
				  	<div class="progress mb-5">
						<div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				    <div class="card border-primary mb-3">
					  	<div class="card-header">Problem 2</div>
				  		<div class="card-body">
					    	
					    	<div class="card-text">
					    		<p>What is the next prime number after 7?</p>
					    		
								<div class="form-text" ><input type="text" class="form-text-input" placeholder="Answer"></div>
								
					    	</div>

					  	</div>
					</div>
					<div class="clearfix">
						<button class="btn btn-secondary previous" data-page="2">Previous</button>
	    				<button class="btn btn-primary next float-right" data-page="2">Next</button>
	    			</div>
				</div>
				<div id="question3" class="problems">
					<p class="lead" style="font-weight:bold;color:white;">Complete 20%</p>
				  	<div class="progress mb-5">
						<div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				    <div class="card border-primary mb-3">
					  	<div class="card-header">Problem 3</div>
				  		<div class="card-body">
					    	
					    	<div class="card-text">
					    		<p>A clock strikes once at 1 o’clock, twice at 2 o’clock, thrice at 3 o’clock and so on. How many times will it strike in 24 hours?</p>
					    		
								<div class="form-check">
									<input class="form-check-input" name="radio1" type="radio" value="78">78
								</div>
								<div class="form-check">
									<input class="form-check-input" name="radio1" type="radio" value="136">136
								</div>
								<div class="form-check">
									<input class="form-check-input" name="radio1" type="radio" value="156">156
								</div>
								<div class="form-check">
									<input class="form-check-input" name="radio1" type="radio" value="196">196
								</div>
								
					    	</div>

					  	</div>
					</div>
					<div class="clearfix">
						<button class="btn btn-secondary previous" data-page="3">Previous</button>
	    				<button class="btn btn-primary next float-right" data-page="3">Next</button>
	    			</div>
				</div>
				<div id="question4" class="problems">
					<p class="lead" style="font-weight:bold;color:white;">Complete 30%</p>
				  	<div class="progress mb-5">
						<div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				    <div class="card border-primary mb-3">
					  	<div class="card-header">Problem 4</div>
				  		<div class="card-body">
					    	
					    	<div class="card-text">
					    		<p>What are the three primary colours?</p>
					    		
								<div class="form-check">
									<input class="form-check-input" name="check1" type="checkbox" value="Blue">Blue
								</div>
								<div class="form-check">
									<input class="form-check-input" name="check1" type="checkbox" value="Red">Red
								</div>
								<div class="form-check">
									<input class="form-check-input" name="check1" type="checkbox" value="Yellow">Yellow
								</div>
								<div class="form-check">
									<input class="form-check-input" name="check1" type="checkbox" value="Black">Black
								</div>
								
					    	</div>

					  	</div>
					</div>
					<div class="clearfix">
						<button class="btn btn-secondary previous" data-page="4">Previous</button>
	    				<button class="btn btn-primary next float-right" data-page="4">Next</button>
	    			</div>
				</div>
				<div id="question5" class="problems">
					<p class="lead" style="font-weight:bold;color:white;">Complete 40%</p>
				  	<div class="progress mb-5">
						<div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				    <div class="card border-primary mb-3">
					  	<div class="card-header">Problem 5</div>
				  		<div class="card-body">
					    	
					    	<div class="card-text">
					    		<p>In which direction do we see the sunrise?</p>
					    		
					    		<div class="src text-center mb-3">
					    			<img src="images/sunrise.jpg" class="obj">
				    			</div>

								<div class="form-check">
									<input class="form-check-input" name="check2" type="radio" value="Blue">South
								</div>
								<div class="form-check">
									<input class="form-check-input" name="check2" type="radio" value="Red">East
								</div>
								<div class="form-check">
									<input class="form-check-input" name="check2" type="radio" value="Yellow">North
								</div>
								<div class="form-check">
									<input class="form-check-input" name="check2" type="radio" value="Black">West
								</div>
								
					    	</div>

					  	</div>
					</div>
					<div class="clearfix">
						<button class="btn btn-secondary previous" data-page="5">Previous</button>
	    				<button class="btn btn-primary next float-right" data-page="5">Next</button>
	    			</div>
				</div>-->
			</div>
		</div>
	</div>
</div>
<script>
	$('.slides').addClass('d-none');
	var count = $('.slides').length;
	$('#slide'+1).removeClass('d-none');
	var correct = 0;
	var wrong = 0;
	var score = 0;

	$(document).on('click','.next',function(){
	    var last=parseInt($(this).data('page'));     
	    var nex = last+1;
	    $('#slide'+last).addClass('d-none');
	    
	    $('#slide'+nex).removeClass('d-none');
	});

	$(document).on('click','.previous',function(){
	    var last=parseInt($(this).data('page'));     
	    var pre = last-1;
	    $('#slide'+last).addClass('d-none');
	    
	    $('#slide'+pre).removeClass('d-none');
	});

	$(document).on('click','.finish',function(){
	    var last=parseInt($(this).data('page'));     
	    var nex = last+1;
	    $('#slide'+last).addClass('d-none');
	    
	    $('#slide'+nex).removeClass('d-none');

	    $('#correct').html(correct);
	    $('#wrong').html(wrong);
	});

	$(document).on('click','.retake',function(){
	    location.reload();
	});

	$('.srcimg').draggable();
	$('.dstimg').droppable({
		drop: function( event, ui ) {
			var src = ui.draggable.attr('src');
			var des = $(this).attr('src');
			var desfile = des.split('\\').pop().split('/').pop();
			if(desfile !== "blank.jpg") {
				$('.srcimg').each(function( index ) {
					var src = $(this).attr('src');
					var srcfile = src.split('\\').pop().split('/').pop();
					if(srcfile == desfile) {
						$(this).removeClass('d-none');
						$(this).css({"left": "0px", "top": "0px"});
					}
				});
				//console.log("blank.jpg");
			}
			
			$(this).attr('src', src);
		    ui.draggable.addClass('d-none');
		}
	});

	$(document).on('click','.reset',function(){
		var no = $(this).data('problem');
	    $('.srcimg'+no).each(function( index ) {
			$(this).removeClass('d-none');
			$(this).css({"left": "0px", "top": "0px"});
		});

		$('.answer'+no).each(function( index ) {
			$(this).attr('src','images/blank.jpg');
		});
	});

	$(document).on('click','.submit',function(){
		var id = $(this).data('id');  
	    var no = $(this).data('problem');     
	    var type = $(this).data('problem-type');
	    var btnclass = $(this).data('button');
	    var btnsubmit = $(this);

	    btnsubmit.attr('disabled', true);

	    if(type=='dragndrop') {
	    	var name = 'answer'+no;
	    	var arr = [];
            $.each($('img.'+name), function() {
            	var file = $(this).attr('src').split('\\').pop().split('/').pop();
                arr.push(file);
            });
	    	var ans = arr.join("$$");
	    	var path=null;
	    	
			$.ajax({
			    type: "post",
			    url: "result.php",
			    data: { id: id, func: 'getImagePathById' },
			    success: function(data){
				    $('#rst'+no).remove();
				    var page = no + 1;
				    $('<button class="btn btn-primary '+btnclass+'" data-page="'+page+'">Next</button>').insertAfter(btnsubmit);
				    $(btnsubmit).remove();

			        path=data;
			    },
			    complete:function(){
			    		
			        $.ajax('result.php', {
					    type: 'POST',  // http method
					    data: { id: id, func: 'getAnswerById' },  // data to submit
					    success: function (data, status, xhr) {
					    	$('.srcimg'+no).draggable({ disabled: true });

					    	if(ans !== data) {
					    		wrong++;
					    		$('#sign'+no).html('<p class="text-danger text-center" style="font-size:24px;font-weight:bold;">&#10060; WRONG</p>');
					    		var html = 'Correct answer: <br>';

					    		var imgs = data.split('$$');
				    		
					    		for (i = 0; i < imgs.length; i++) {
					    			html += '<img src="'+path+'/'+imgs[i]+'" class="solimg">';
								}

					    		$('#solution'+no).html(html);
					    		$('#solution'+no).removeClass('d-none');
					    	} else {
					    		correct++;
					    		score++;
					    		$('.score').html('Your Score: '+score);
					    		$('#sign'+no).html('<p class="text-success text-center" style="font-size:24px;font-weight:bold;">&#10004; CORRECT</p>');

					    	}
					        //location.reload();
					    },
					    error: function (jqXhr, textStatus, errorMessage) {
					        alert('Error' + errorMessage);
					    }
					});
			    },
			    error: function (jqXhr, textStatus, errorMessage) {
			        alert('Error' + errorMessage);
			    }
		    });

	    } else if(type=='text') {
	    	var name = 'answer'+no;
	    	var ans = $.trim($('input[name ="'+name+'"]').val());
	    	$.ajax('result.php', {
				    type: 'POST',  // http method
				    data: { id: id, func: 'getAnswerById' },  // data to submit
				    success: function (data, status, xhr) {
				    	$('input[name ="'+name+'"]').attr('disabled', true);

				    	var page = no + 1;
					    $('<button class="btn btn-primary '+btnclass+'" data-page="'+page+'">Next</button>').insertAfter(btnsubmit);
					    $(btnsubmit).remove();

				    	if(ans !== data) {
				    		wrong++;
				    		$('#sign'+no).html('<p class="text-danger text-center" style="font-size:24px;font-weight:bold;">&#10060; WRONG</p>')
				    		$('#solution'+no).html('Correct answer: '+data)
				    		$('#solution'+no).removeClass('d-none');
				    	} else {
				    		correct++;
				    		score++;
					    	$('.score').html('Your Score: '+score);
				    		$('#sign'+no).html('<p class="text-success text-center" style="font-size:24px;font-weight:bold;">&#10004; CORRECT</p>')
				    	}
				        //location.reload();
				    },
				    error: function (jqXhr, textStatus, errorMessage) {
				        alert('Error' + errorMessage);
				    }
				});
	    } else if(type=='single') {
	    	var name = 'answer'+no;
	    	var ans = $('input[name="'+name+'"]:checked').val();
	    	$.ajax('result.php', {
				    type: 'POST',  // http method
				    data: { id: id, func: 'getAnswerById' },  // data to submit
				    success: function (data, status, xhr) {
				    	$('input[name="'+name+'"]').each(function( index ) {
							$(this).attr('disabled',true);
						});

				    	var page = no + 1;
					    $('<button class="btn btn-primary '+btnclass+'" data-page="'+page+'">Next</button>').insertAfter(btnsubmit);
					    $(btnsubmit).remove();

				    	if(ans !== data) {
				    		wrong++;
				    		$('#sign'+no).html('<p class="text-danger text-center" style="font-size:24px;font-weight:bold;">&#10060; WRONG</p>')
				    		$('#solution'+no).html('Correct answer: '+data)
				    		$('#solution'+no).removeClass('d-none');
				    	} else {
				    		correct++;
				    		score++;
					    	$('.score').html('Your Score: '+score);
				    		$('#sign'+no).html('<p class="text-success text-center" style="font-size:24px;font-weight:bold;">&#10004; CORRECT</p>')
				    	}
				    },
				    error: function (jqXhr, textStatus, errorMessage) {
				        alert('Error' + errorMessage);
				    }
				});
	    } else if(type=='multiple') {
	    	var name = 'answer'+no;
	    	var arr = [];
            $.each($('input[name="'+name+'"]:checked'), function() {
                arr.push($(this).val());
            });
	    	var ans = arr.join("$$");
	    	$.ajax('result.php', {
				    type: 'POST',  // http method
				    data: { id: id, func: 'getAnswerById' },  // data to submit
				    success: function (data, status, xhr) {
				    	$('input[name="'+name+'"]').each(function( index ) {
							$(this).attr('disabled',true);
						});

				    	var page = no + 1;
					    $('<button class="btn btn-primary '+btnclass+'" data-page="'+page+'">Next</button>').insertAfter(btnsubmit);
					    $(btnsubmit).remove();
				    
				    	if(ans !== data) {
				    		wrong++;
				    		$('#sign'+no).html('<p class="text-danger text-center" style="font-size:24px;font-weight:bold;">&#10060; WRONG</p>')
				    		var sol = data.split('$$');
				    		var text = '';
				    		for (i = 0; i < sol.length; i++) {

								if(i == sol.length-1) {
									text += 'and "'+ sol[i] + '"';
								} else {
									text += '"'+ sol[i] + '", ';
								}
							}
							
				    		$('#solution'+no).html('Correct answer: '+text)
				    		$('#solution'+no).removeClass('d-none');
				    	} else {
				    		correct++;
				    		score++;
					    	$('.score').html('Your Score: '+score);
				    		$('#sign'+no).html('<p class="text-success text-center" style="font-size:24px;font-weight:bold;">&#10004; CORRECT</p>')
				    	}
				        //location.reload();
				    },
				    error: function (jqXhr, textStatus, errorMessage) {
				        alert('Error' + errorMessage);
				    }
				});
	    }

	    
	});
	
</script>
</body>
</html>
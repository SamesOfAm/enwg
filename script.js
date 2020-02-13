function selectImage(element) {
    e = element || event;
    let number = 0;
    if(isNaN(parseInt(e.attributes[2].value))){
        number = e.attributes[1].value;
    } else {
        number = parseInt(e.attributes[2].value);
    }
    document.getElementById('background').style.backgroundImage = "url('img" + number + ".jpg')";
    document.getElementById('imageSelect').selectedIndex = number - 1;
    let buttons = document.getElementsByClassName('button');
    for(let i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('selected');
        buttons[number-1].classList.add('selected');
    }
}

function showCustomMessage(textarea, option) {
	document.getElementById(textarea).style.display = option.checked === true ? 'block' : 'none';
}

function validateEmail(email) {
	let re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	return re.test(String(email).toLowerCase());
}

function validateEmails(emails) {
	let output = true;
	let mails = emails.split(",");
	mails.forEach(function(email) {
		let re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		re.test(String(email.trim()).toLowerCase());
		if(re.test(String(email.trim()).toLowerCase()) === false){
			output = false;
		}

	});
	return output;
}

function validateForm() {
	document.form.nameSender.style.border = '1px solid transparent';
	document.form.emailSender.style.border = '1px solid transparent';
	document.form.emailRecipient.style.border = '1px solid transparent';
	document.getElementById('nameSenderError').style.display = 'none';
	document.getElementById('emailSenderError').style.display = 'none';
	document.getElementById('emailRecipientError').style.display = 'none';
	if(document.form.nameSender.value === '') {
		document.form.nameSender.style.border = '1px solid red';
		document.getElementById('nameSenderError').style.display = 'block';
	}
	if (document.form.emailSender.value === '' || !validateEmail(document.form.emailSender.value)) {
		document.form.emailSender.style.border = '1px solid red';
		document.getElementById('emailSenderError').style.display = 'block';
	}
	if (document.form.emailRecipient.value === '' || !validateEmails(document.form.emailRecipient.value)) {
		document.form.emailRecipient.style.border = '1px solid red';
		document.getElementById('emailRecipientError').style.display = 'block';
	} else {
		return true;
	}
	return false;
}

window.onload = function(){
	//canvas init
	var canvas = document.getElementById("content");
	var ctx = canvas.getContext("2d");

	//canvas dimensions
	var W = window.innerWidth;
	var H = window.innerHeight;
	canvas.width = W;
	canvas.height = H;

	//snowflake particles
	var mp = 2020; //max particles
	var particles = [];
	for(var i = 0; i < mp; i++)
	{
		particles.push({
			x: Math.random()*W, //x-coordinate
			y: Math.random()*H, //y-coordinate
			r: Math.random()*2+1, //radius
			d: Math.random()*mp //density
		})
	}

	//Lets draw the flakes
	function draw()
	{
		ctx.clearRect(0, 0, W, H);

		ctx.fillStyle = "rgba(255, 255, 255, 0.8)";
		ctx.beginPath();
		for(var i = 0; i < mp; i++)
		{
			var p = particles[i];
			ctx.moveTo(p.x, p.y);
			ctx.arc(p.x, p.y, p.r, 0, Math.PI*7, true);
		}
		ctx.fill();
		update();
	}

	//Function to move the snowflakes
	//angle will be an ongoing incremental flag. Sin and Cos functions will be applied to it to create vertical and horizontal movements of the flakes
	var angle = 0;
	function update()
	{
		angle += 0.01;
		for(var i = 0; i < mp; i++)
		{
			var p = particles[i];
			//Updating X and Y coordinates
			//We will add 1 to the cos function to prevent negative values which will lead flakes to move upwards
			//Every particle has its own density which can be used to make the downward movement different for each flake
			//Lets make it more random by adding in the radius
			p.y += Math.cos(angle+p.d) + 1 + p.r/2;
			p.x += Math.sin(angle) * 2;

			//Sending flakes back from the top when it exits
			//Lets make it a bit more organic and let flakes enter from the left and right also.
			if(p.x > W+5 || p.x < -5 || p.y > H)
			{
				if(i%3 > 0) //66.67% of the flakes
				{
					particles[i] = {x: Math.random()*W, y: -10, r: p.r, d: p.d};
				}
				else
				{
					//If the flake is exitting from the right
					if(Math.sin(angle) > 0)
					{
						//Enter from the left
						particles[i] = {x: -5, y: Math.random()*H, r: p.r, d: p.d};
					}
					else
					{
						//Enter from the right
						particles[i] = {x: W+5, y: Math.random()*H, r: p.r, d: p.d};
					}
				}
			}
		}
	}

	//animation loop
	setInterval(draw, 35);
}

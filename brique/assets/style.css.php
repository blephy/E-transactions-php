<style>
html {
	font-size: 100%;
	font-family: 'Source Sans Pro', sans-serif;
}
body {
	background-color: #cccccc;
	color: #646464;
	font-size: 16px;
	font-size: 0.9rem;
	position: relative;
	width: 100%;
	min-height: 100vh;
	margin: 0;
	padding: 0;
}
.entete {
	text-align: center;
	box-sizing: border-box;
	padding: 10px;
}
h1 {
	margin: 20px 0;
	color: #383a6d;
	font-weight: bolder;
	text-transform: uppercase;
	letter-spacing: 1.5px;
	word-spacing: 7px;
}
.info {
	display: block;
	box-sizing: border-box;
	padding: 10px;
	line-height: 20px;
	text-align: center;
}
p {
	box-sizing: border-box;
	width: 90%;
	margin: 0px auto 10px auto;
	padding: 10px;
	background-color: rgba(20, 150, 150, 0.3);
	border-radius: 5px;
	letter-spacing: 1.5px;
}
.alert {
	background-color: rgba(208, 129, 0, 0.3);
}
.error {
  background-color: rgba(208, 30, 0, 0.3);
}
@keyframes load {
	from {
		transform: scale(0.8);
	}

	to {
		transform: scale(1.3);
	}
}
span.loading {
	display: block;
	width: 50px;
	height: 50px;
	background-color: transparent;
	border: 4px green solid;
	border-radius: 50%;
	margin: 50px auto 50px auto;
	animation: load 0.6s infinite alternate;
}
#form {
	margin: auto;
	text-align: center;
}
.inline {
	display: inline;
}
input[type="submit"], button {
	cursor: pointer;
	margin: 15px 20px;
	background-color: #4CADC9;
	text-transform: uppercase;
	height: 50px;
	border: none;
	line-height: 50px;
	border-radius: 0;
	padding: 0 10px;
	box-sizing: border-box;
	font-size: 1.3rem;
	transition: all 0.3s ease-out;
	font-family: 'Source Sans Pro', sans-serif;
	line-height: 40px;
	box-shadow: 0px 0px 7px 2px rgba(0, 255, 255, 0.2);
}

input[type="submit"]:hover, button:hover {
	box-shadow: 0px 0px 15px 5px rgba(76,173,201,0.20);
}
a {
	text-decoration: none;
	color: inherit;
	font-weight: bold;
}
a:hover {

}
@media print {
	button {
		display: none;
	}
}
</style>

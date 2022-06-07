<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "content-user-show-requests.css" ?>">
	<script src="../../external/script/javascript.js"></script>
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" />
	<title>Moja dela</title>
</head>

<body>
	<div></div>
	<div class="form">
		<span class="span-login">MOJA NAROČENA DELA</span>
		<div class="works">
			<?php
				$j=1;
				for ($i=0; true; $i++) {
					$a = "var$i";
					if (!isset($$a)) break;
					$data = $$a;
					
					foreach ($_SESSION["data"]["requestedJobs"] as $el) {
						if ($el["id_delo"] == $data["id_delo"]) {
							?>
							<hr/>
							<div>
								<div>
									<p class="name-of-input"><u><?= $j ?>. DELO:</u>
									<?php
									if (empty($el["obravnava"])) {
										echo '<label> Brez obravnave </label>';
									} else {
										if ($el["obravnava"] == 'potrjeno') {
											echo '<label style="color: green;"> Potrjeno</label>';
										} else if ($el["obravnava"] == 'zavrnjeno') {
											echo '<label style="color: red;">Zavrnjeno</label>';
										}
									}
									?>
									</p>
									<p class="name-of-input">Podjetje: <span><?= $data["naziv_podjetja"] ?></span></p>
									<p class="name-of-input">Naziv: <span><?= $data["naziv"] ?></span></p>
									<p class="name-of-input">Plača:<span> <?= number_format($data["placa"], 2) ?> €/h</span></p>

								</div>
								<div>
									<p class="name-of-input req"><u>NAROČILO</u></p>
										<form class="form-delete" action="<?= BASE_URL . "content/user-show-requests" ?>" method="post">
											<input type="hidden" name="id_delo" value="<?= $el["id_delo"] ?>" />
											<button class="btn btn-warning button-input" onclick="return confirm('Ali res želite izbrisati to naročilo?')">ODSTRANI NAROČILO</button>
										</form>
										<br/>
										<br/>
									<textarea class="form-control textarea-for-request" disabled ><?= $el["besedilo"] ?></textarea>
								</div>
							</div>
							<?php
							$j++;
							break;
						}
					}
				}
			?>
		</div>
	</div>
	<div></div>
</body>
</html>
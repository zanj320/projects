<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "content-company-view-request.css" ?>">
	<script src="../../external/script/javascript.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" >
	<title>Naročila</title>
</head>

<body>
	<div></div>
	<div class="form">
		<span class="span-login">VSA NAROČILA NA DELA</span>
		<div class="works">
			<?php
				$countVsa = 0;
				while (true) {
					$a = "var$countVsa";
					if (!isset($$a)) break;
					$countVsa++;
				}
				
				for ($i=0; true; $i++) {
					$a = "var$i";
					if (!isset($$a)) break;
					
					$data = $$a;
					?>
					<hr>
					<div class="request-data">
						<div><b>Naziv dela: </b><?= $data["naziv"] ?></div>
						<div><b>Datum objave dela: </b><?= $data["datum_objave_delo"] ?></div>
						<br/>
						<div><b>Ime in priimek prijavljenega: </b><?= $data["ime"] . ' ' . $data["priimek"] ?></div>
						<div><b>E-naslov prijavljenega: </b><?= $data["email"] ?></div>
						<div><b>Telefonska prijavljenega: </b><?= $data["telefon"] ?></div>
						<div><b>Datum objave prosnje: </b><?= $data["datum_objave_prosnja"] ?></div>
					</div>
					<br>
					
					<div class="name-of-input">BESEDILO PRIJAVLJENEGA
						<?php
							if (!empty($data["obravnava"]) && $data["obravnava"] == 'potrjeno')
								echo '<span style="color: green; display: inline;">Potrjeno</span>';
							else if (!empty($data["obravnava"]) && $data["obravnava"] == 'zavrnjeno') {
								echo '<span style="color: red; display: inline;">Zavrnjeno</span>';
							}
						?>
					</div>
					<textarea class="form-control textarea-for-request" disabled><?= $data["besedilo"] ?></textarea>
					
					<form action="<?= BASE_URL . "content/company-manage-user" ?>" method="post">
						<input type="hidden" name="id_delo" value="<?= $data["id_delo"] ?>" />
						<input type="hidden" name="id_uporabnik" value="<?= $data["id_uporabnik"] ?>" />
						<div class="confirm-buttons">
							<?php if (empty($data["obravnava"])) { ?>
								<button class="btn btn-info btn-lg button-input" name="potrdi">POTRDI</button>
								<div></div>
								<button class="btn btn-info btn-lg button-input" name="zavrni">ZAVRNI</button>
							<?php } else {
								if ($data["obravnava"] == 'potrjeno') {
								?>
									<button class="btn btn-info btn-lg button-input" name="zavrni">ZAVRNI</button>
								<?php
								} else if ($data["obravnava"] == 'zavrnjeno') {
								?>
									<button class="btn btn-info btn-lg button-input" name="potrdi">POTRDI</button>
								<?php
								}
								?>
								<div></div>
								<button class="btn btn-info btn-lg button-input" name="ponastavi">PONASTAVI</button>
								<?php
							}
							?>
						</div>
					</form>
					<?php
				}
			?>
		</div>
	</div>
	<div></div>
</body>
</html>
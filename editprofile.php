<?php
//If user wanna edit his profil
$res = $db->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."';");
$row = $res->fetchArray();
?>
<div class="col-12 col-lg-3">
    <a> Username: (Cannot be changed) </a><input type="input" id="username" value=<?php echo $row["username"]; ?> readonly>
</div>
<div class="col-12 col-lg-3">
    <a>Password: </a><input type="password" id="password" placeholder="Password">
</div>
<div class="col-12 col-lg-3">
    <a> E-Mail: </a><input type="input" id="email" value=<?php echo $row["email"]; ?>>
</div>
<div class="col-12 col-lg-3">
    <a>Name: </a><input type="input" id="name" value=<?php echo $row["name"]; ?>>
</div>
<div class="col-12 col-lg-3">
    <a>Last Name: </a><input type="input" id="last_name" value=<?php echo $row["last_name"]; ?>>
</div>
<div class="col-12 col-lg-3">
    <a>Adress: </a><input type="input" id="adress" value=<?php echo $row["adress"]; ?>>
</div>
<div class="col-12 col-lg-3">
    <a>Phone: </a><input class="form-control" type="text" pattern="[0-9]{2}[0-9]{8}" id="phone" value=<?php echo $row["phone_number"]; ?>>
</div>
<div class="col-12 col-lg-3">
    <a>Birthdate: </a><input type="date" id="birthdate" value=<?php echo $row["birthdate"]; ?>>
</div>
</form>
</div>
</div>
</div>
</section>

<?php
    if ($row["type"] == '1') {
        $icon_pet = "<i class='fa-solid fa-cat'></i>";
    } else {
        $icon_pet = "<i class='fa-solid fa-dog'></i>";
    }
?>

<div class="mb-3 card rounded-4">
    <div class="card-header">
        <h4><?php echo $icon_pet; ?> Pet information </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3 col-xl-2" style="text-align:center;">
                <img class="mt-3 mb-3 rounded-4" src="../../<?php echo $row["path"]; ?>" alt="Card image" width="100%">
            </div>
            <div class="col-lg-9 col-xl-10">
                <div class="row mb-2">
                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                        <label for="pname"> Name : </label>
                    </div>
                    <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                        <input type="text" class="form-control" id="pname" name="pname" readonly value="<?php echo $row["name"]; ?>" />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                        <label for="type"> Type : </label>
                    </div>
                    <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                        <input type="text" class="form-control" id="type" name="type" readonly value="<?php echo ucfirst($row["type_name"]); ?>" />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                        <label for="breed"> Breed : </label>
                    </div>
                    <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                        <input type="text" class="form-control" id="breed" name="breed" readonly value="<?php echo $row["breed"]; ?>" />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                        <label for="age"> Age : </label>
                    </div>
                    <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="age" name="age" readonly value="<?php echo $row["age"]; ?>" />
                            <span class="input-group-text"> Year </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                        <label for="gender"> Gender : </label>
                    </div>
                    <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                        <input type="text" class="form-control" id="gender" name="gender" readonly value="<?php echo $row["gender"]; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3 row justify-content-end">
            <div class="col- col-sm-4 col-xl-1">
                <a class="text-in-button" href="edit_pet.php?editId=<?php echo $row["pet_id"]; ?>">
                    <button type="button" class="mb-4 btn btn-success btn-sm submitbtn" style="width: 100%;margin: 0 !important;">
                        Edit
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
<?php 
include 'db.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Export Report</title>

    <style>
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            background: rgba(0,0,0,0.5);
        }

        
        .report-box{
            width:620px;
            margin:80px auto;
            background:#f3f5f7;
            border-radius:10px;
            box-shadow:0 5px 15px rgba(0,0,0,0.3);
        }

        .report-head{
            text-align:center;
            padding:15px;
            font-size:20px;
            font-weight:bold;
            color:#1f3c5b;
            border-bottom:1px solid #ddd;
        }

        .report-body{
            padding:30px 50px;
        }

        .row{
            display:flex;
            align-items:center;
            margin-bottom:18px;
        }

        .row label{
            width:220px;
            font-weight:bold;
            color:#1f3c5b;
        }

        .row input{
            width:200px;
            padding:6px;
            border:1px solid #ccc;
        }

        .confirm-text{
            text-align:center;
            margin-top:25px;
            font-weight:bold;
            color:#1f3c5b;
        }

        .footer{
            display:flex;
            border-top:1px solid #ddd;
        }

        .action-btn{
            flex:1;
            padding:15px;
            border:none;
            font-weight:bold;
            cursor:pointer;
            background:#e9ecef;
        }

        .action-btn:hover{
            background:#d6d8db;
        }

        .firm-select{
            position:relative;
            width:380px;
        }

        .firm-display{
            width:100%;
            border:1px solid #ccc;
            padding:6px;
            background:#fff;
            height:34px;
            display:flex;
            align-items:center;
            cursor:pointer;
        }

        .firm-options{
            display:none;
            position:absolute;
            top:36px;
            left:0;
            width:100%;
            background:#fff;
            border:1px solid #ccc;
            max-height:180px;
            overflow:auto;
            z-index:9999;
        }

        .firm-options label{
            display:flex;
            gap:6px;
            padding:6px;
            font-size:13px;
            cursor:pointer;
            white-space:nowrap;
        }

        .firm-options label:hover{
            background:#f1f1f1;
        }
    </style>
</head>

<body>

<div class="report-box">

    <div class="report-head">
        Export Report
    </div>

    <form method="POST" action="download.php" onsubmit="return checkForm()">

        <div class="report-body">

            <div class="row">
                <label>Select Firm code</label>

                <div class="firm-select">

                    <div class="firm-display" onclick="toggleFirmBox()" id="firmText">
                        Select Firm(s)
                    </div>

                    <div class="firm-options" id="firmList">
                        <?php
                        $q = $conn->query("SELECT * FROM firms");
                        while($f = $q->fetch_assoc()){
                            ?>
                            <label>
                                <input type="checkbox" value="<?php echo $f['atty_cde']; ?>" onchange="collectFirms()">
                                <?php echo $f['atty_cde']." - ".$f['atty_name']; ?>
                            </label>
                            <?php
                        }
                        ?>
                    </div>

                </div>
            </div>

            
            <input type="hidden" name="firm_code" id="firmHidden">

        
            <div class="row">
                <label>Start Date(YYYYMMDD)</label>
                <input type="text" name="start_date">
            </div>

            <div class="row">
                <label>End Date(YYYYMMDD)</label>
                <input type="text" name="end_date">
            </div>

            <div class="confirm-text">
                Are you sure you want to download ?
            </div>

        </div>

        <div class="footer">
            <button type="submit" class="action-btn">Download</button>
            <button type="button" class="action-btn" onclick="hideBox()">Close</button>
        </div>

    </form>

</div>

<script>

function toggleFirmBox(){
    let el = document.getElementById("firmList");
    if(el.style.display === "block"){
        el.style.display = "none";
    }else{
        el.style.display = "block";
    }
}

function collectFirms(){
    let all = document.querySelectorAll("#firmList input[type=checkbox]");
    let arr = [];

    for(let i=0;i<all.length;i++){
        if(all[i].checked){
            arr.push(all[i].value);
        }
    }

    document.getElementById("firmHidden").value = arr.join(",");

    let text = document.getElementById("firmText");

    if(arr.length === 0){
        text.innerText = "Select Firm(s)";
    }else{
        text.innerText = arr.length + " selected";
    }
}

function checkForm(){
    let val = document.getElementById("firmHidden").value;

    if(val == ""){
        alert("Select at least one firm");
        return false;
    }
    return true;
}

function hideBox(){
    document.querySelector(".report-box").style.display = "none";
    document.body.style.background = "#fff";
}

// outside click close
document.addEventListener("click", function(e){
    let wrap = document.querySelector(".firm-select");
    let list = document.getElementById("firmList");

    if(wrap && !wrap.contains(e.target)){
        list.style.display = "none";
    }
});

</script>

</body>
</html>
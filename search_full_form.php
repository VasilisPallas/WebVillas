<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Vasilis Pallas, Maria Konovesi">
<?php require('style1.php'); ?> 

<div class="center">
    <form name="search" id="search" method="GET" action="#">
        <h2>Περιοχή <input class="inputs" placeholder="πχ Κέρκυρα" style="width:70%; margin-left: 10px;" type="text" id="area" name="area" size="25" maxlength="25"/></h2>
        <table>
            <tr>
                <td><h2>Τιμή Από</h2></td>
                <td><input class="inputs" placeholder="" style="width:80px; margin-left: 10px;" type="text" id="from" name="from" size="25" maxlength="25"/> Εώς<input class="inputs" placeholder="" style="width:80px; margin-left: 10px;" type="text" id="to" name="to" size="25" maxlength="25"/>
                </td>
            </tr>

            <tr>
                <td><h2>Επισκέπτες</h2></td>
                <td>    
                    <input class="numberinputs" placeholder="" style="width:80px; margin-left: 10px;" type="number" id="capacity" value="1" name="capacity" min="1" max="10" size="25" maxlength="25"/>
                </td>
            </tr>

            <tr>
                <td><h2>Εγκαταστάσεις</h2></td>
                <td><label><input type="checkbox" id="garage" name="garage" value="1" >Γκαράζ</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="checkbox" id="wifi" name="wifi" value="1" >Wi-Fi</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="checkbox" id="pool" name="pool" value="1" >Πισίνα</label>
                    <br/><br/>
                    <label><input type="checkbox" id="jacuzzi" name="jacuzzi" value="1" >Τζακούζι</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="checkbox" id="spa" name="spa" value="1" >Spa</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="checkbox" id="gym" name="gym" value="1" >Γυμναστήριο</label> </td>
            </tr>

            <tr>
                <td>
                    <h2>Αστέρων</h2> 
                </td>
                <td>
                    <div class="rating">
                        <input type="radio" name="rating" value="0" checked /><span id="hide"></span>
                        <input type="radio" name="rating" value="1" /><span></span>
                        <input type="radio" name="rating" value="2" /><span></span>
                        <input type="radio" name="rating" value="3" /><span></span>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td><input class="bluebutton" style="margin: -15px 0 10px 220px" type="submit" value="Αναζήτηση"/></td>
            </tr>            
        </table>
    </form>
</div>

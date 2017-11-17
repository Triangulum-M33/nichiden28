<?php
ini_set('display_errors', "Off");
//POSTで送信されたデータを変数に格納
if(isset($_POST['filename'])){
    $filename = $_POST['filename'];
    //echo $filename;
}
if(isset($_POST['day'])){
    $day = $_POST['day'];
    //echo $day;
}
if(isset($_POST['title'])){
    $title = $_POST['title'];
    //echo $title;
}
if(isset($_POST['staffname'])){
    $staffname = $_POST['staffname'];
    //echo $staffname;
}
$count = 1;
if(isset($_POST['count'])){
    $count = $_POST['count'];
    //echo $count;
}
//ここからは配列
if(isset($_POST['word'])){
    $word = $_POST['word'];
}
if(isset($_POST['timing'])){
    $timing = $_POST['timing'];
    //var_dump($timing);
}
$projector_a = $_POST['projector_a'];
    //var_dump($projector_a);
$projector_b = $_POST['projector_b'];
    //var_dump($projector_b);
$projector_c = $_POST['projector_c'];
    //var_dump($projector_c);
$projector_d = $_POST['projector_d'];
    //var_dump($projector_d);
$projector_e = $_POST['projector_e'];
    //var_dump($projector_e);

$on_off_a_ = $_POST['on_off_a_'];
$on_off_b_ = $_POST['on_off_b_'];
$on_off_c_ = $_POST['on_off_c_'];
$on_off_d_ = $_POST['on_off_d_'];
$on_off_e_ = $_POST['on_off_e_'];

$DATA_ARRAY = array(
    "info" => array(
        "day" => $day,
        "title" => $title,
        "name" => $staffname,
    ),
    "scenario" => array( 
        array(
            "timing" => "",
            "word" => "",
            "projector" => array(
                "Fst" => 1,
                "Gxy" => 1,
             ),
        ),
    ),
);
    //projectorの中に入れるarrayを調整
    for($n = 0;$n < 5; $n++){
        if($projector_a[$n] == "XXX"){
            unset($projector_a[$n]);
            unset($on_off_a_[$n]);
        }
        if($projector_b[$n] == "XXX"){
            unset($projector_b[$n]);
            unset($on_off_b_[$n]);
        }
        if($projector_c[$n] == "XXX"){
            unset($projector_c[$n]);
            unset($on_off_c_[$n]);
        }
        if($projector_d[$n] == "XXX"){
            unset($projector_d[$n]);
            unset($on_off_d_[$n]);
        }
        if($projector_e[$n] == "XXX"){
            unset($projector_e[$n]);
            unset($on_off_e_[$n]);
        }
        
    }
    $on_off_alt_a = clone_int($on_off_a_);
    $on_off_alt_b = clone_int($on_off_b_);
    $on_off_alt_c = clone_int($on_off_c_);
    $on_off_alt_d = clone_int($on_off_d_);
    $on_off_alt_e = clone_int($on_off_e_);

    function clone_int( $array ){
        if( is_array($array) ){
            return array_map("clone_int",$array);
        }else{
            return intval($array);
        }
    }


    //scenarioの中に入れるarrayを作成
    for($i = 1;$i < $count+1 ; $i++){
        $DATA_ARRAY["scenario"][$i] = array(
            "timing" => $timing[$i-1],
            "word" => $word[$i-1],
            "projector" => array(
                $projector_a[$i-1] => $on_off_alt_a[$i-1],
                $projector_b[$i-1] => $on_off_alt_b[$i-1],
                $projector_c[$i-1] => $on_off_alt_c[$i-1],
                $projector_d[$i-1] => $on_off_alt_d[$i-1],
                $projector_e[$i-1] => $on_off_alt_e[$i-1],
            ),
        );
        $DATA_ARRAY["scenario"][$i]["projector"] = array_filter($DATA_ARRAY["scenario"][$i]["projector"],"strlen");
    }
    
    //print_r($DATA_ARRAY);
    
    $make = json_encode($DATA_ARRAY,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    
    //使用時はこの行をアクティブにすること
    if($filename)
        file_put_contents("jsonBOX/".$filename.".json",$make);
    
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <title>Acrab_Config</title>
  <script src="jquery-3.1.0.js"></script>
  <script src="script.js"></script>
  <link rel="stylesheet" type="text/css" href="AcrabConfigCSS.css">
</head>
<body>
    <h1>Acrab_Config</h1>
    <form  name="frm" action="Acrab_Config.php" method="post" >
            <p>ファイル名：<br>
                <input type="text" id="filename" name="filename"/></p>
            <p>公演日:<br>
              <select id="day" name="day">
                  <option value="ソフト">ソフト</option>
                  <option value="一日目">一日目</option>
                  <option value="二日目">二日目</option>
                  <option value="三日目">三日目</option>
              </select></p>
            <p>タイトル:<br>
                <input type="text" id="title" name="title"/> </p>
            <p>担当者:<br>
                <input type="text" id="staffname" name="staffname"/></p>
                <div class="form-block" id="form_block[0]">
                    <!-- Closeボタン -->
                    <button type="button" id="close" style="display: none;">-</button>
                    <!--タイミング（ラジオボタン）-->
                    <p>タイミング:前<input type="radio" id="timing_pre[0]" name="timing[0]" value="pre" checked="checked"/>
                        後<input type="radio" id="timing_post[0]" name="timing[0]" value="post"/></p>
                    <!--表示星座絵（セレクト）-->
                    <p>操作:<br>
                        <select id="projector_a[0]" name="projector_a[0]">
                            <option value="XXX">--使用星座絵を選択--</option> <option value="And">アンドロメダ</option> 
                            <option value="Sgr">いて</option> <option value="Pse">うお</option>
                            <option value="Lep">うさぎ</option>　<option value="Boo">うしかい</option>　<option value="Tau">おうし</option>
                            <option value="CMa">おおいぬ</option> <option value="UMa">おおぐま</option> <option value="Vir">おとめ</option>
                            <option value="Ari">おひつじ</option> <option value="Ori">オリオン</option> <option value="Cas">カシオペヤ</option>
                            <option value="Cnc">かに</option> <option value="Crv">からす</option> <option value="Aur">ぎょしゃ</option>
                            <option value="Cet">くじら</option> <option value="Cep">ケフェウス</option> <option value="CMi">こいぬ</option>
                            <option value="UMi">こぐま</option> <option value="Lyr">こと</option> <option value="Sco">さそり</option>
                            <option value="Leo">しし</option> <option value="Lib">てんびん</option> <option value="Cyg">はくちょう</option>
                            <option value="Gem">ふたご</option> <option value="Peg">ペガスス</option> <option value="Per">ペルセウス</option>
                            <option value="Aqr">みずがめ</option> <option value="Cap">やぎ</option> <option value="Aql">わし</option>
                            <option value="Him">織姫</option> <option value="Hik">彦星</option> 
                            <option value="Spc">春の大曲線</option> <option value="Spt">春の大三角</option> <option value="Smt">夏の大三角</option>
                            <option value="Wnt">冬の大三角</option> <option value="Twv">黄道十二星座</option> 
                            <option value="Wnd">冬のダイヤモンド</option> <option value="Eti">エチオピア神話</option>
                        </select>
                        <!--星座表示on/off（ラジオボタン）-->
                        on<input type="radio" id="on_a[0]" name="on_off_a_[0]" value= 1 checked="checked"/>
                        off<input type="radio" id="off_a[0]" name="on_off_a_[0]" value= 0 checked="checked"/><br>
                        <select id="projector_b[0]" name="projector_b[0]">
                            <option value="XXX">--使用星座絵を選択--</option> <option value="And">アンドロメダ</option> 
                            <option value="Sgr">いて</option> <option value="Pse">うお</option>
                            <option value="Lep">うさぎ</option>　<option value="Boo">うしかい</option>　<option value="Tau">おうし</option>
                            <option value="CMa">おおいぬ</option> <option value="UMa">おおぐま</option> <option value="Vir">おとめ</option>
                            <option value="Ari">おひつじ</option> <option value="Ori">オリオン</option> <option value="Cas">カシオペヤ</option>
                            <option value="Cnc">かに</option> <option value="Crv">からす</option> <option value="Aur">ぎょしゃ</option>
                            <option value="Cet">くじら</option> <option value="Cep">ケフェウス</option> <option value="CMi">こいぬ</option>
                            <option value="UMi">こぐま</option> <option value="Lyr">こと</option> <option value="Sco">さそり</option>
                            <option value="Leo">しし</option> <option value="Lib">てんびん</option> <option value="Cyg">はくちょう</option>
                            <option value="Gem">ふたご</option> <option value="Peg">ペガスス</option> <option value="Per">ペルセウス</option>
                            <option value="Aqr">みずがめ</option> <option value="Cap">やぎ</option> <option value="Aql">わし</option>
                            <option value="Him">織姫</option> <option value="Hik">彦星</option>
                            <option value="Spc">春の大曲線</option> <option value="Spt">春の大三角</option> <option value="Smt">夏の大三角</option>
                            <option value="Wnt">冬の大三角</option> <option value="Twv">黄道十二星座</option> 
                            <option value="Wnd">冬のダイヤモンド</option> <option value="Eti">エチオピア神話</option>
                        </select>
                        on<input type="radio" id="on_b[0]" name="on_off_b_[0]" value= 1 checked="checked"/>
                        off<input type="radio" id="off_b[0]" name="on_off_b_[0]" value= 0 checked="checked"/><br>
                        <select id="projector_c[0]" name="projector_c[0]">
                            <option value="XXX">--使用星座絵を選択--</option> <option value="And">アンドロメダ</option> 
                            <option value="Sgr">いて</option> <option value="Pse">うお</option>
                            <option value="Lep">うさぎ</option>　<option value="Boo">うしかい</option>　<option value="Tau">おうし</option>
                            <option value="CMa">おおいぬ</option> <option value="UMa">おおぐま</option> <option value="Vir">おとめ</option>
                            <option value="Ari">おひつじ</option> <option value="Ori">オリオン</option> <option value="Cas">カシオペヤ</option>
                            <option value="Cnc">かに</option> <option value="Crv">からす</option> <option value="Aur">ぎょしゃ</option>
                            <option value="Cet">くじら</option> <option value="Cep">ケフェウス</option> <option value="CMi">こいぬ</option>
                            <option value="UMi">こぐま</option> <option value="Lyr">こと</option> <option value="Sco">さそり</option>
                            <option value="Leo">しし</option> <option value="Lib">てんびん</option> <option value="Cyg">はくちょう</option>
                            <option value="Gem">ふたご</option> <option value="Peg">ペガスス</option> <option value="Per">ペルセウス</option>
                            <option value="Aqr">みずがめ</option> <option value="Cap">やぎ</option> <option value="Aql">わし</option>
                            <option value="Him">織姫</option> <option value="Hik">彦星</option>
                            <option value="Spc">春の大曲線</option> <option value="Spt">春の大三角</option> <option value="Smt">夏の大三角</option>
                            <option value="Wnt">冬の大三角</option> <option value="Twv">黄道十二星座</option> 
                            <option value="Wnd">冬のダイヤモンド</option> <option value="Eti">エチオピア神話</option>
                        </select>
                        on<input type="radio" id="on_c[0]" name="on_off_c_[0]" value= 1 checked="checked"/>
                        off<input type="radio" id="off_c[0]" name="on_off_c_[0]" value= 0 checked="checked"/><br>
                        <select id="projector_d[0]" name="projector_d[0]">
                            <option value="XXX">--使用星座絵を選択--</option><option value="And">アンドロメダ</option> 
                            <option value="Sgr">いて</option> <option value="Pse">うお</option>
                            <option value="Lep">うさぎ</option>　<option value="Boo">うしかい</option>　<option value="Tau">おうし</option>
                            <option value="CMa">おおいぬ</option> <option value="UMa">おおぐま</option> <option value="Vir">おとめ</option>
                            <option value="Ari">おひつじ</option> <option value="Ori">オリオン</option> <option value="Cas">カシオペヤ</option>
                            <option value="Cnc">かに</option> <option value="Crv">からす</option> <option value="Aur">ぎょしゃ</option>
                            <option value="Cet">くじら</option> <option value="Cep">ケフェウス</option> <option value="CMi">こいぬ</option>
                            <option value="UMi">こぐま</option> <option value="Lyr">こと</option> <option value="Sco">さそり</option>
                            <option value="Leo">しし</option> <option value="Lib">てんびん</option> <option value="Cyg">はくちょう</option>
                            <option value="Gem">ふたご</option> <option value="Peg">ペガスス</option> <option value="Per">ペルセウス</option>
                            <option value="Aqr">みずがめ</option> <option value="Cap">やぎ</option> <option value="Aql">わし</option>
                            <option value="Him">織姫</option> <option value="Hik">彦星</option>
                            <option value="Spc">春の大曲線</option> <option value="Spt">春の大三角</option> <option value="Smt">夏の大三角</option>
                            <option value="Wnt">冬の大三角</option> <option value="Twv">黄道十二星座</option> 
                            <option value="Wnd">冬のダイヤモンド</option> <option value="Eti">エチオピア神話</option>
                        </select>
                        on<input type="radio" id="on_d[0]" name="on_off_d_[0]" value= 1 checked="checked"/>
                        off<input type="radio" id="off_d[0]" name="on_off_d_[0]" value= 0 checked="checked"/><br>
                        <select id="projector_e[0]" name="projector_e[0]">
                            <option value="XXX">--使用星座絵を選択--</option><option value="And">アンドロメダ</option> 
                            <option value="Sgr">いて</option> <option value="Pse">うお</option>
                            <option value="Lep">うさぎ</option>　<option value="Boo">うしかい</option>　<option value="Tau">おうし</option>
                            <option value="CMa">おおいぬ</option> <option value="UMa">おおぐま</option> <option value="Vir">おとめ</option>
                            <option value="Ari">おひつじ</option> <option value="Ori">オリオン</option> <option value="Cas">カシオペヤ</option>
                            <option value="Cnc">かに</option> <option value="Crv">からす</option> <option value="Aur">ぎょしゃ</option>
                            <option value="Cet">くじら</option> <option value="Cep">ケフェウス</option> <option value="CMi">こいぬ</option>
                            <option value="UMi">こぐま</option> <option value="Lyr">こと</option> <option value="Sco">さそり</option>
                            <option value="Leo">しし</option> <option value="Lib">てんびん</option> <option value="Cyg">はくちょう</option>
                            <option value="Gem">ふたご</option> <option value="Peg">ペガスス</option> <option value="Per">ペルセウス</option>
                            <option value="Aqr">みずがめ</option> <option value="Cap">やぎ</option> <option value="Aql">わし</option>
                            <option value="Him">織姫</option> <option value="Hik">彦星</option>
                            <option value="Spc">春の大曲線</option> <option value="Spt">春の大三角</option> <option value="Smt">夏の大三角</option>
                            <option value="Wnt">冬の大三角</option> <option value="Twv">黄道十二星座</option> 
                            <option value="Wnd">冬のダイヤモンド</option> <option value="Eti">エチオピア神話</option>
                        </select>
                        on<input type="radio" id="on_e[0]" name="on_off_e_[0]" value= 1 checked="checked"/>
                        off<input type="radio" id="off_e[0]" name="on_off_e_[0]" value= 0 checked="checked"/><br>
                    </p>
                    <p>セリフ:<br>
                        <textarea id="word[0]" name="word[0]" rows="6" cols="60"></textarea>
                    </p>
                </div>
        <div class="form-block" id="form_add">
            <button type="button" id="add">+</button>
        </div>
        <div class="form-block" id="form_send"><br>
            <input type="button" id="send_button"  value="送信"  />
        <!--    <input type="reset" id="reset_button" value="リセット"/>    -->
        </div>
        <!--script.js内でフォーム個数をカウントするfrm_cntグローバル変数を受け取ってphpに渡す用-->
        <input type="hidden" name="count" value="" />
      </form>
</body>
</html>
  


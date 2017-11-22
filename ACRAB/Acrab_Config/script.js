$(function () {
    var frm_cnt = 0;
    $('#add').click(this,function(){
        //オリジナルを取得
        var original = $('#form_block\\[' + frm_cnt + '\\]');
        var originCnt = frm_cnt;
        var origintiming = $("input[name='timing\\[" + frm_cnt + "\\]']:checked").val();
        var originradio_a = $("input[name='on_off_a_\\[" + frm_cnt + "\\]']:checked").val();
        var originradio_b = $("input[name='on_off_b_\\[" + frm_cnt + "\\]']:checked").val();
        var originradio_c = $("input[name='on_off_c_\\[" + frm_cnt + "\\]']:checked").val();
        var originradio_d = $("input[name='on_off_d_\\[" + frm_cnt + "\\]']:checked").val();
        var originradio_e = $("input[name='on_off_e_\\[" + frm_cnt + "\\]']:checked").val();
        
        frm_cnt++;　//カウント1増やす
　　　　　
　　　　　original
          .clone() //クローン
          .hide()  //一旦隠す
          .insertAfter(original) //オリジナルの後ろに突っ込む
          .attr('id', 'form_block[' + frm_cnt + ']') // クローンのid属性を変更。
          .find("input[type='radio'][checked]").prop('checked', true)
          .end() // 一度適用する
          .find('input, textarea, select').each(function(idx, obj) {　//inputとtextareaのidとnameを置き換える
              $(obj).attr({
                  id: $(obj).attr('id').replace(/\[\d{1,3}\]+$/, '[' + frm_cnt + ']'),
                  name: $(obj).attr('name').replace(/\[\d{1,3}\]+$/, '[' + frm_cnt + ']')
              });
              if ($(obj).attr('id') == 'word['+ frm_cnt +']') { //textの値をクリア
                $(obj).val('');
              }
          });
        
          var clone = $('#form_block\\[' + frm_cnt + '\\]');
          clone.children('button#close').show();
          clone.slideDown('slow');
          original.find("input[name='timing\\[" + originCnt + "\\]'][value='" + origintiming + "']").prop('checked', true);
          original.find("input[name='on_off_a_\\[" + originCnt + "\\]'][value='" + originradio_a + "']").prop('checked', true);
          original.find("input[name='on_off_b_\\[" + originCnt + "\\]'][value='" + originradio_b + "']").prop('checked', true);
          original.find("input[name='on_off_c_\\[" + originCnt + "\\]'][value='" + originradio_c + "']").prop('checked', true);
          original.find("input[name='on_off_d_\\[" + originCnt + "\\]'][value='" + originradio_d + "']").prop('checked', true);
          original.find("input[name='on_off_e_\\[" + originCnt + "\\]'][value='" + originradio_e + "']").prop('checked', true);
        
    });
    $(document).on('click','#close',function(){
        var removeObj = $(this).parent();
        removeObj.fadeOut('fast', function() {
            removeObj.remove();
            // 番号振り直し
            frm_cnt = 0;
            $(".form-block[id^='form_block']").each(function(index, formObj) {
                if ($(formObj).attr('id') != 'form_block[0]') {
                    frm_cnt++;
                    $(formObj)
                        .attr('id', 'form_block[' + frm_cnt + ']') // id属性を変更。
                        .find('input, textarea, select').each(function(idx, obj) {
                            $(obj).attr({
                                id: $(obj).attr('id').replace(/\[[0-9]\]+$/, '[' + frm_cnt + ']'),
                                name: $(obj).attr('name').replace(/\[[0-9]\]+$/, '[' + frm_cnt + ']')
                            });
                        });
                }
            });
        });
    });
    $('#send_button').click(this,function(){
        document.forms['frm'].elements['count'].value = frm_cnt + 1;
        document.frm.submit();
    });
    //さあ、画面の前の君もレッツコナミコマンド！
     var inputKey = [];
     var konamiCommand = [38,38,40,40,37,39,37,39,66,65];
     $(window).keyup(function(e) {
        inputKey.push(e.keyCode);
        if (inputKey.toString().indexOf(konamiCommand) >= 0) {
            $('#listmake').css("display","inline");
            inputKey = [];
        }
      });
});
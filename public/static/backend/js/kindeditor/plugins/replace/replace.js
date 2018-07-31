/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('replace', function(K) {
	var self = this, name = 'replace';var hasLoad = false;
    self.clickToolbar(name, function() {
        self.focus();
        $('.divWrap').show();
        if(!hasLoad) {
            hasLoad = true;
            $("#save_rep").bind('click',function () {
                var html = self.html();
                html = html.replace(/&nbsp;/g,' ');
                var search_txt = $('input[name=search_text]').val().trim(),replace_txt = $('input[name=replace_text]').val().trim();
                if(search_txt==''){
                    alert("You didn't enter anything to search.");
                    return false;
                }
                var match = search_txt.length==1 && ( (search_txt.indexOf('*')> -1) || (search_txt.indexOf('/')>-1 )|| (search_txt.indexOf('<')>-1) || (search_txt.indexOf('>')>-1)
                || (search_txt.indexOf(':')>-1)||(search_txt.indexOf('.')>-1)||(search_txt.indexOf('-')>-1)||(search_txt.indexOf('&')>-1)||(search_txt.indexOf(',')>-1) );
                if(match){
                    alert("The search content cant't contain special characters.");
                    return false;
                }
                var n=(html.split(search_txt)).length-1;
                if(n <=0){
                    alert("Didn't find anything that matches your search.");
                    return false;
                }
                if(search_txt=='('  ){
                    html = html.replace(/\(/g,replace_txt);
                } else if (search_txt==')') {
                    html = html.replace(/\)/g,replace_txt);
                } else if(search_txt.indexOf('(')>-1 && search_txt.indexOf('(')>-1){
                    for(var i=0;i<20;i++){
                        html = html.replace(search_txt,replace_txt);
                    }
                } else if (search_txt.indexOf('+')>-1) {
                    for(var i=0;i<20;i++){
                        html = html.replace(search_txt,replace_txt);
                    }
                } else {
                    var reg = new RegExp(search_txt, "g");
                    html = html.replace(reg,replace_txt);
                }

                self.html(html);
                $('input[name=search_text]').val('');
                $('input[name=replace_text]').val('');
                $('.divWrap').hide();
                if(n >0 ){
                    alert("Completed. "+n+" places have been replaced.");
                } else {
                    alert("Didn't find anything that matches your search.");
                }
            });
            $("#cancel_rep").bind('click',function () {
                $('input[name=search_text]').val('');
                $('input[name=replace_text]').val('');
                $('.divWrap').hide();
            });
        }

    });

});

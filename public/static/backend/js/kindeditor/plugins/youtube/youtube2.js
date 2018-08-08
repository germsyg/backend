/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('youtube', function(K) {
	var self = this, name = 'youtube';
	self.plugin.youtube = {
		edit : function() {
			var lang = self.lang(name),
				html = '<div style="padding:20px;">' +
					//url
					'<div class="ke-dialog-row">' +
					'<label for="keYoutube" style="width:60px;">Youtube</label>' +
					'<input class="ke-input-text" type="text" id="keYoutube" name="youtube" value="" style="width:260px;" /></div>'
					,
				dialog = self.createDialog({
					name : name,
					width : 450,
					title : self.lang(name),
					body : html,
					yesBtn : {
						name : self.lang('yes'),
						click : function(e) {
							var url = K.trim(urlBox.val());
							function parse_url(_url){ //���庯��
								var pattern = /(\w+)=(\w+)/ig;//����������ʽ
								var parames = {};//��������
								url.replace(pattern, function(a, b, c){
									parames[b] = c;
								});
								return parames;//�����������.
							}
							
							//var parames = parse_url(url);
							//var urlv = parames['v'];
							var urlv = url;
							//if (url == 'http://' || K.invalidUrl(url) || !urlv) {
							if (url == 'http://' || !urlv) {
								alert(self.lang('invalidUrl'));
								urlBox[0].focus();
								return;
							}
							
							self.exec('createyoutube', urlv).hideDialog().focus();
						}
					}
				}),
				div = dialog.div,
				urlBox = K('input[name="youtube"]', div);
			urlBox.val('http://');
		}
	};
	self.clickToolbar(name, self.plugin.youtube.edit);
});

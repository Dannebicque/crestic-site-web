var	g_initialize = null;

var route_tinyMCEDialogFile = null;

function setRouteTinyMCEDialogFile (_route)
{
	route_tinyMCEDialogFile = _route;
}


function init (_this , _type)
{
	var label_titre =  $(_this).find('.TDataEditionDialog label');
	if (label_titre.hasClass('required') == true && label_titre.text().indexOf('*')== - 1 )
	{
		label_titre.html ('<div style="color:red;font-weight:bold;font-size:24px;line-height:24px;float:left;margin-right:4px" >* </div>' + label_titre.text());
	}
	switch (_type)
	{
		case 'image':
		{
			//Initialisation du clicke lorsqu'on charge une image
			var input_file = $(_this).find('.TDataEditionDialog input:file');
			var input_text = $(_this).find('.TDataEditionDialog input:text');
			input_text.hide();
			var image = $(_this).find('.TDataEditionDialog img');

			$('input_text').attr('readonly', true);
			$(input_file).on('change', function () {
				var reader = new FileReader();
				reader.onload = function (_event)
				{
					var src = _event.target.result;
					$(image).attr('src', src);
					$(input_text).val(src);
				}
				reader.readAsDataURL($(input_file)[0].files[0]);
			});

			break;
		}
		case 'textarea_url':
		{
			break;
		}
		case 'textarea':
		{
			break;
		}

		case 'date' :
		{
			var input_date = $(_this).find('input[type="date"]');
			$(input_date).attr('type','text');
			$(input_date).val('10/01/2000');
			$(input_date).datepicker(
				{
					dateFormat : 'dd/mm/yy',
					minDate    : '01/01/1900',
					maxDate    : '01/01/2100'
				});
			var input_date = $(_this).find('.TDataEditionDialog').find('input[type="text"]');
			var currentText = $(input_date).datepicker({ dateFormat: 'dd/mm/yy' }).val();
			break;
		}

        case 'heure' :
        {
            break;
        }

		case 'choice':
		{
			var select = $(_this).find ('select');

			if (select.attr('readonly') == 'readonly')
			{
				select.bind('mousedown', function (e) { e.preventDefault();} );
			}
			else
			{
				select.select2();
			}
			$('.select2-container').css ('width', '100%');
			$('.select2-container').css ('display', 'inline-block');
			$('.select2-selection').css ('height', '42px');
			$('.select2-selection').css ('border-radius', '0px');
			$('.select2-selection__arrow').css ('height', '40px');
			$('.select2-selection__rendered').css ('line-height', '42px');
			break;
		}

		case 'textarea_tinymce':
		{
			var id_textarea = $(_this).find('.TDataEditionDialog').find('textarea').attr('id');
			console.log (id_textarea);

			tinymce.init({
				selector: '#' + id_textarea,
				setup: function (editor) {
					editor.on('change', function () {
						editor.save();
					});
				},
				plugins: "base64image",
				menubar: "insert",
				toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | base64image",
				image_caption: true,
				//automatic_uploads: true,
				image_advtab: true,

			});
			break;
		}

		case 'pdf' :
		{
			var frame 	=  $(_this).find('.TDataEditionDisplayValue').find('iframe');
			$(frame).attr('height' , $(window).height()-110);
			//displayOnTwoColonne (_this);

			//Initialisation du clicke lorsqu'on charge une image
			var input_file 	= $(_this).find('.TDataEditionDialog input:file');
			var input_text 	= $(_this).find('.TDataEditionDialog input:text');
			input_text.hide();
			var iframe 		= $(_this).find('.TDataEditionDisplayValue iframe');

			$('input_text').attr ('readonly',true);
			$(input_file).on('change', function ()
			{
				var reader = new FileReader();
				reader.onload = function (_event) {
					var src = _event.target.result;
					$(iframe).attr('src', src);
					$(input_text).val(src);
				}

				reader.readAsDataURL($(input_file)[0].files[0]);
			});
			break;
		}
		default:
		{
			break;
		}
	}
}

function initDataEditions()
{

	tinyMCE.editors=[];

	$(".TDataEdition").each(function()
	{
		init (this , $(this).attr('data-type'));
	});
}


$(document).ready  (function()
{
	tinymce.PluginManager.add("base64image", function (a, b, route) {
		a.addButton("base64image", {
			icon: "image",
			tooltip: "Insert/edit image",
			onclick: function () {
				a.windowManager.open({
					title: "Insert/edit image",
					url: route_tinyMCEDialogFile,
					width: 375,
					height: 165,
					buttons: [{
						text: "Insert",
						onclick: function () {
							var b = a.windowManager.getWindows()[0];

							a.insertContent('<img src="' + b.getContentWindow().document.getElementById("url").value + '">'), b.close()
						}
					}, {
						text: "Close",
						onclick: "close"
					}]
				})
			}
		}), a.addMenuItem("base64image", {
			icon: "image",
			text: "Insert/edit image",
			context: "insert",
			prependToContext: !0,
			onclick: function () {
				a.windowManager.open({
					title: "Insert/edit image",
					url: route_tinyMCEDialogFile,
					width: 420,
					height: 165,
					buttons: [{
						text: "Insert",
						onclick: function () {
							var b = a.windowManager.getWindows()[0];

							a.insertContent('<img src="' + b.getContentWindow().document.getElementById("url").value + '">'), b.close()
						}
					}, {
						text: "Close",
						onclick: "close"
					}]
				})
			}
		})
	});
});
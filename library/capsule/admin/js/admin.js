jQuery.noConflict()(function($) {
	//Event listener for document click
	$(document).click(function(u) {
		var mine = u.target.className;
		if (mine != 'optionGearContentAct' && mine != 'optionGear optionGearActive') {
			$('.optionGear').removeClass('optionGearActive');
			$('.optionGearContent').remove();
		}
	});
	$(document).ready(function() {
		$.fn.center = function() {
			this.css("position", "absolute");
			this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
			this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
			return this;
		}
		$.fn.centerFixed = function() {
			this.css("position", "fixed");
			this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
			this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
			return this;
		}
		$.fn.centerOnly = function() {
			this.css("position", "absolute");
			this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
			return this;
		}
		//Global variable to be used in the application
		var page;
		var menuLast;
		var editable = '';
		var contentID = '';
		var notContent = '';
		var administratorSitesFolder = $('#adminContainer').attr('data-folder');
		//Save button on the content editor handler, when you mouseover it change the image to hover state
		$('.contentSubmit').live('mouseover', function() {
			var ajaxCondition = $(this).html();
			if (ajaxCondition != 'Save') {
				$(this).html('').html('<img class="buttonAjaxLoader" src="library/capsule/admin/image/ajax-loaderHover.gif" />');
			}
		});
		//Save button on the content editor handler, when you mouseout it change the image to normal state
		$('.contentSubmit').live('mouseout', function() {
			var ajaxCondition = $(this).html();
			if (ajaxCondition != 'Save') {
				$(this).html('').html('<img class="buttonAjaxLoader" src="library/capsule/admin/image/ajax-loader.gif" />');
			}
		});
		//Handler for primary checkbox
		$('.admin-MenuSet thead input[type="checkbox"],.admin-MenuList thead input[type="checkbox"],.admin-userSet thead input[type="checkbox"],.admin-tagonomySet thead input[type="checkbox"]').live('change', function() {
			if (this.checked) {
				$(this).parent().parent().parent().parent().find('tbody input[type="checkbox"]').attr('checked', true);
			} else {
				$(this).parent().parent().parent().parent().find('tbody input[type="checkbox"]').attr('checked', false);
			}
		})
		//Event listener for design mode
		$('.adminDesign').live('click', function() {
			var state = $(this).text();
			if (state == 'Design') {
				$(this).text('Save');
				$('div[name=capsuleContainer]').css({
					"border": "2px dotted #383838",
					"overflow": "hidden",
					"padding-top": "20px"
				});
			} else {
				$(this).text('Design');
				$('div[name=capsuleContainer]').removeAttr("style");
				var pathToPage = $('input[name="pagePathToFile"]').val();
				var include = "library/capsule/admin/admin.main.php";
				var capsuleIDS = [];
				$('div[name=capsuleContainer]').each(function(i) {
					var capsuleID = $(this).find('input[name="capsuleID"]').val();
					var capsuleNo = $(this).attr('capsuleID');
					var capsuleOpt = $(this).find('input[name="initWithOption"]').val();
					if (capsuleID != undefined) {
						capsuleIDS[i] = {};
						capsuleIDS[i]['capsuleID'] = capsuleID;
						capsuleIDS[i]['containerNo'] = capsuleNo;
						if (capsuleOpt != '') {
							capsuleIDS[i]['capsuleOption'] = capsuleOpt;
						}
					}
				});
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: capsuleIDS,
					pageID: pathToPage,
					incl: include,
					control: 'admin/savePageLayout'
				}, function(data) {
					//alert(data);
				});
			}
			return false;
		});
		$('#adminMenuSet li').hover(function() {
			var info = $.trim($(this).text().replace(/ /g, ''));
			var position = $(this).offset();
			var menu = eval(info);
			if (menuLast != info) {
				if (menu != undefined) {
					$('.adminMenuPopUp').remove();
					menuLast = info;
					$('#adminContainer').append('<div class="adminMenuPopUp"><div class="adminMenuPopUpPointer"></div><div class="adminMenuPopUpContainer"></div></div>');
					$('.adminMenuPopUp').hide();
					$('.adminMenuPopUp').css("top", position.top + 40 + "px").css("left", position.left + 20 + "px");
					$('.adminMenuPopUpContainer').html(menu);
					$('.adminMenuPopUp').draggable({
						opacity: 0.35
					});
					$('.dragCapsule').draggable({
						helper: 'clone',
						revert: false,
						start: function(e, ui) {
							var text = $(this).text();
							var val = $(this).find('input[name="capID"]').val();
							var incl = $(this).find('input[name="capInclude"]').val();
							ui.helper.html('<input type="hidden" class="capid" value="' + val + '"><input type="hidden" class="capincl" value="' + incl + '">Drop this ' + text + ' capsule into div</span>');
							ui.helper.addClass('dragCapsuleStart');
						}
					});
					$('.adminMenuPopUp').show("fade", {}, 250);
				} else {
					menuLast = info;
					$('.adminMenuPopUp').hide("fade", {}, 150, function() {
						$(this).remove();
					});
				}
			}
			return false;
		});
		//Event listener for application capsule when the app button is clicked
		$('.adminTablePopUpCapsuleApp').live('click', function() {
			$('.adminMenuPopUp').remove();
			var path = $(this).attr('init');
			page = $('body').html();
			$.post(path, {
				control: "init"
			}, function(view) {
				$('body').html(view);
			});
		});
		$('.adminReturningButton').live('click', function() {
			$('body').html(page);
			page = '';
		});
		$('.adminExit').live('click', function() {
			$('.admin-popUpMenu,#overlay').remove();
			$('.adminExit').hide();
		});
		//Event listener for admin menu set clickable
		$('#adminMenuSet li').live('click', function() {
			var info = $.trim($(this).text().replace(/ /g, ''));
			notContent = '';
			if (info == 'Capsule') {
				return false;
			}
			$('.admin-popUpMenu,#overlay').remove();
			var check = $('#overlay').length;
			$('.adminExit').show();
			//Run when the admin menu is clicked
			if (info == 'Sites') {
				var include = "library/capsule/admin/admin.main.php";
				$('body').append('<div class="admin-popUpMenu"></div>');
				$('.admin-popUpMenu').centerOnly();
				$('.admin-popUpMenu').html('Loading...');
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					incl: include,
					control: 'admin/getSitesList'
				}, function(data) {
					$('.admin-popUpMenu').html(data);
					if ($('.total-adminPagging').val() <= 1 || $('.curent-adminPagging').val() >= $('.total-adminPagging').val()) {
						$('.next-adminPagging').attr("disabled", "disabled");
						$('.next-adminPagging').click(false);
					} else {
						$('.next-adminPagging').removeAttr("disabled");
					}
					if ($('.total-adminPagging').val() == 1 || $('.curent-adminPagging').val() > $('.total-adminPagging').val()) {
						$('.prev-adminPagging').attr("disabled", "disabled");
						$('.next-adminPagging').click(false);
					} else {
						$('.prev-adminPagging').removeAttr("disabled");
					}
					$('.administrator-select').chosen();
					$('.admin-popUpMenu table:not(#admin-menuSet)').hide();
					editable = '';
					contentID = '';
				});
			} else if (info == 'Menu') {
				var include = "library/capsule/admin/admin.main.php";
				var currentDomain = document.domain;
				//console.log(currentDomain);
				$('body').append('<div class="admin-popUpMenu"></div>');
				$('.admin-popUpMenu').centerOnly();
				$('.admin-popUpMenu').html('Loading...');
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					incl: include,
					mainID: currentDomain,
					control: 'admin/getMenuList'
				}, function(data) {
					$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
					var totalPage = $('.total-adminPagging').val();
					totalPage = parseInt(totalPage);
					var currentPage = $('.curent-adminPagging').val();
					currentPage = parseInt(currentPage);
					if (totalPage > 1 && currentPage <= totalPage) {
						$('.next-adminPagging').removeAttr("disabled");
					} else {
						$('.next-adminPagging').attr("disabled", "disabled");
						$('.next-adminPagging').click(false);
					}
					if (currentPage > 1 && currentPage <= totalPage) {
						$('.prev-adminPagging').removeAttr("disabled");
					} else {
						$('.prev-adminPagging').attr("disabled", "disabled");
						$('.prev-adminPagging').click(false);
					}
					$('.admin-menuChooser').chosen();
					$('.administrator-select').chosen();
					$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();
					$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
						incl: include,
						control: 'admin/getLanguage'
					}, function(lang) {
						$('.admin-languageSelect').html(lang).hide();
						$('.admin-languageSelect select').chosen();
					});
				});
			} else if (info == 'Content') {
				var include = "library/capsule/admin/admin.main.php";
				$('body').append('<div class="admin-popUpMenu"></div>');
				$('.admin-popUpMenu').centerOnly();
				$('.admin-popUpMenu').html('Loading...');
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					incl: include,
					control: 'admin/getContentList'
				}, function(data) {
					$('.admin-popUpMenu').html(data);
					$('.administrator-select-global-site').chosen();
					$('.admin-popUpMenu table:not(#admin-menuSet)').hide();
					editable = '';
					contentID = '';
				});
			} else if (info == 'Tagonomy') {
				var include = "library/capsule/admin/admin.main.php";
				$('body').append('<div class="admin-popUpMenu"></div>');
				$('.admin-popUpMenu').centerOnly();
				$('.admin-popUpMenu').html('Loading...');
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					incl: include,
					control: 'admin/getTagonomyList'
				}, function(data) {
					$('.admin-popUpMenu').html(data);
					var totalPage = $('.total-adminPagging').val();
					totalPage = parseInt(totalPage);
					var currentPage = $('.curent-adminPagging').val();
					currentPage = parseInt(currentPage);
					if (totalPage > 1 && currentPage <= totalPage) {
						$('.next-adminPagging').removeAttr("disabled");
					} else {
						$('.next-adminPagging').attr("disabled", "disabled");
						$('.next-adminPagging').click(false);
					}
					if (currentPage > 1 && currentPage <= totalPage) {
						$('.prev-adminPagging').removeAttr("disabled");
					} else {
						$('.prev-adminPagging').attr("disabled", "disabled");
						$('.prev-adminPagging').click(false);
					}
					$('.administrator-select').chosen();
					$('.admin-popUpMenu table:not(#admin-menuSet)').hide();
					editable = '';
					contentID = '';
				});
			} else if (info == 'User') {
				var include = "library/capsule/admin/admin.main.php";
				$('body').append('<div class="admin-popUpMenu"></div>');
				$('.admin-popUpMenu').centerOnly();
				$('.admin-popUpMenu').html('Loading...');
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					incl: include,
					control: 'admin/getUserList'
				}, function(data) {
					$('.admin-popUpMenu').html(data);
					var totalPage = $('.total-adminPagging').val();
					totalPage = parseInt(totalPage);
					var currentPage = $('.curent-adminPagging').val();
					currentPage = parseInt(currentPage);
					if (totalPage > 1 && currentPage <= totalPage) {
						$('.next-adminPagging').removeAttr("disabled");
					} else {
						$('.next-adminPagging').attr("disabled", "disabled");
						$('.next-adminPagging').click(false);
					}
					if (currentPage > 1 && currentPage <= totalPage) {
						$('.prev-adminPagging').removeAttr("disabled");
					} else {
						$('.prev-adminPagging').attr("disabled", "disabled");
						$('.prev-adminPagging').click(false);
					}
					$('.administrator-select').chosen();
					$('.admin-popUpMenu table:not(#admin-menuSet)').hide();
					editable = '';
					contentID = '';
				});
			} else if (info == 'Role') {
				var include = "library/capsule/admin/admin.main.php";
				var mainID = document.domain;
				$('body').append('<div class="admin-popUpMenu"></div>');
				$('.admin-popUpMenu').centerOnly();
				$('.admin-popUpMenu').html('Loading...');
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					incl: include,
					mainID: mainID,
					control: 'admin/getRoleList'
				}, function(data) {
					$('.admin-popUpMenu').html(data);
					var totalPage = $('.total-adminPagging').val();
					totalPage = parseInt(totalPage);
					var currentPage = $('.curent-adminPagging').val();
					currentPage = parseInt(currentPage);
					if (totalPage > 1 && currentPage <= totalPage) {
						$('.next-adminPagging').removeAttr("disabled");
					} else {
						$('.next-adminPagging').attr("disabled", "disabled");
						$('.next-adminPagging').click(false);
					}
					if (currentPage > 1 && currentPage <= totalPage) {
						$('.prev-adminPagging').removeAttr("disabled");
					} else {
						$('.prev-adminPagging').attr("disabled", "disabled");
						$('.prev-adminPagging').click(false);
					}
					$('.administrator-select').chosen({
						include_group_label_in_selected: true
					});
					$('.admin-popUpMenu table:not(#admin-menuSet)').hide();
					editable = '';
					contentID = '';
				});
			}
			if (info == 'Info') {
				var text = '<div class="admin-popUpHeader">Neyka Ver 1.5</div>' + '<div class="admin-second-actionbar" style="clear:both; width:100%; height:50px;">' + 'Created by <b>Asacreative team (Ridwan Abadi, Erwin Yudha Pratama and Rendi Eka Putra Suherman)</b> 2008 - 2012 all rights reserved. ' + 'We give many thanks to our family, friends and colleague for the unlimited support, unwavering trust to our ability, their love and care to make this system come true. ' + 'Special thanks to <b>Erwin Yudha Pratama</b> whom loyalities and trust keep the single leader of Asacreative keep on fighting and refused to give up to learn. We will never forget your deeds forever.' + '</div>';
				$('body').append('<div class="admin-popUpMenu admin-popUpMenuSmall"></div>');
				$('.admin-popUpMenu').centerOnly();
				$('.admin-popUpMenu').html(text);
			}
			//Check whether the overlay is already displayed on screen. If it isn't, display it.
			if (check != 1) {
				var overlay = $('<div id="overlay"></div>');
				overlay.appendTo(document.body);
			}
		});
		//Event listener for menu popUp so it can be arranged by dragging
		$('.draggableMenu').live('mouseover', function() {
			$(".draggableMenu").draggable({
				helper: 'clone',
				handle: '.admin-draggableHandler',
				revert: 'invalid',
				axis: 'y',
				containment: 'parent',
				start: function(e, ui) {
					var myID = $(this).find('input[type=checkbox]').val();
					var childNumber = $('input[name="parentID"][value=' + myID + ']').length;
				},
				stop: function(e, ui) {}
			});
			$('.draggableMenu').droppable({
				hoverClass: "capsuleContainerHover",
				accept: ".draggableMenu",
				drop: function(e, ui) {
					var helperParent = ui.helper.find('input[name="parentID"]').val();
					var helperText = ui.helper.find('input.admin-inputInherit').val();
					var helperID = ui.helper.find('input[type=checkbox]').val();
					var myID = ui.helper.find('input[type=checkbox]').val();
					var childNumber = $('input[name="parentID"][value=' + myID + ']').length;
					if (childNumber != 0) {
						notificationCenter('Warning! ' + ui.helper.find('.admin-inputInherit').val() + ' has child. Remove all the child if you want to move it.');
						return false;
					}
					if (ui.helper.find('img.childMenu').length != 1) {
						var helperHTML = ui.helper.find('.myStyle').html();
						var helperHTML = ui.helper.find('.myStyle').html("<img class='childMenu' src='library/capsule/admin/image/rowChild.png'>" + helperHTML);
					}
					var theID = $(this).find('input[type=checkbox]').val();
					var isChild = $(this).find('td.myStyle img').length;
					if (helperID == theID) {
						return false;
					}
					//Setting new parent id
					var parentID = $(this).find('input[type=checkbox]').val();
					var myStyle = $(this).find('td.myStyle').attr('padding');
					if (myStyle == '0') {
						var myStyle = 12;
					} else {
						var myStyle = parseInt(myStyle) * 2 + 2;
					}
					ui.helper.find('td.myStyle').attr('style', 'padding-left: ' + myStyle + 'px');
					ui.helper.find('td.myStyle').attr('padding', myStyle);
					var final = "<tr class='draggableMenu'>" + ui.helper.html() + "</tr>";
					var locate = $(this).closest("tr").prevAll("tr").length + 1;
					$(this).parent().parent().find('tr').eq(locate).after(final);
					$(this).parent().parent().find('tr').eq(locate + 1).find('input[name="parentID"]').val(parentID);
					$(this).parent().parent().find('tr').eq(locate + 1).find('input.admin-inputInherit').val(helperText);
					ui.helper.remove();
					ui.draggable.remove();
				}
			});
		});
		//Submmiting ajax request for saving the new menu structure
		$('.admin-actContainer-SaveMenuButton').live('click', function() {
			var include = "library/capsule/admin/admin.main.php";
			setPositionOfAllTheTable('.admin-popUpMenu table');
			var id = getInputDataFromTableRowRecursive('.admin-popUpMenu table tbody');
			var lang = $('.admin-languageSelect select').val();
			var idDelLi = $('.deletedMenuList').val();
			var idDelSe = $('.deletedMenuSet').val();
			var mainID = $('.administrator-select-global-site-menu').val();

			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				delMenuList: idDelLi,
				mainID: mainID,
				delMenuSet: idDelSe,
				lang: lang,
				incl: include,
				control: 'admin/saveNewMenuStructure'
			}, function(data) {
				notificationCenter("Menu structure saved!");
				$('.admin-popUpMenu').html(data);
				$('.administrator-select,.admin-menuChooser,.admin-languageSelect select').chosen();
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					var totalPage = $('.total-adminPagging').val();
					totalPage = parseInt(totalPage);
					var currentPage = $('.curent-adminPagging').val();
					currentPage = parseInt(currentPage);
					if (totalPage > 1 && currentPage <= totalPage) {
						$('.next-adminPagging').removeAttr("disabled");
					} else {
						$('.next-adminPagging').attr("disabled", "disabled");
						$('.next-adminPagging').click(false);
					}
					if (currentPage > 1 && currentPage <= totalPage) {
						$('.prev-adminPagging').removeAttr("disabled");
					} else {
						$('.prev-adminPagging').attr("disabled", "disabled");
						$('.prev-adminPagging').click(false);
					}
				});
			});
		});
		//Submitting ajax request for saving tagonomy
		$('.adminSites-actContainer-SaveMenuButton').live('click', function() {
			var include = "library/capsule/admin/admin.main.php";
			var idDelLi = $('.deletedMenuList').val();
			var id = getInputDataFromTableRow('#admin-menuSet tbody');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				delMenuList: idDelLi,
				incl: include,
				control: 'admin/saveNewSites'
			}, function(data) {
				//alert(data);
				notificationCenter("Sites structure saved!");
				$('.admin-popUpMenu').html(data);
			});
		});
		//Submitting ajax request for saving tagonomy
		$('.adminTagonomy-actContainer-SaveMenuButton').live('click', function() {
			var include = "library/capsule/admin/admin.main.php";
			var idDelLi = $('.deletedMenuList').val();
			var currentDomain = $('.administrator-select-global-site-tagonomy').val();
			//console.log(currentDomain)
				if (currentDomain == '' || typeof currentDomain === 'undefined') { currentDomain = ''; }
			//console.log(currentDomain)
			var id = getInputDataFromTableRow('#admin-menuSet tbody');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				delMenuList: idDelLi,
				incl: include,
				mainID: currentDomain,
				control: 'admin/saveNewTagonomy'
			}, function(data) {
				//alert(data);
				notificationCenter("Tagonomy structure saved!");
				$('.admin-popUpMenu').html(data);
				$('.administrator-select').chosen();
			});
		});
		//Submitting ajax request for saving user
		$('.adminUser-actContainer-SaveMenuButton').live('click', function() {
			var include = "library/capsule/admin/admin.main.php";
			if ($('#administrator-user-edit').length == 1) {
				var control = 'admin/editUser';
				var id = getInputDataFromForm('#administrator-user-edit');
			} else if ($('#administrator-user-create').length == 1) {
				var control = 'admin/createUser';
				var id = getInputDataFromForm('#administrator-user-create');
			} else {
				var id = getInputDataFromTableRow('#admin-menuSet tbody');
				var control = 'admin/saveNewUser';
				var idDelLi = $('.deletedMenuList').val();
			}
			var currentDomain = $('.administrator-select-global-site-user').val();
			//console.log(id);
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				mainID: currentDomain,
				delMenuList: idDelLi,
				incl: include,
				control: control
			}, function(data) {
				//console.log(data);
				if (data == 'New User Email, Username and Password Cannot be Empty!' || data == 'Existing User Email, Username and Password Cannot be Empty!') {
					notificationCenter(data);
					return false;
				}
				notificationCenter("Users saved!");
				$('.admin-popUpMenu').html(data);
				$('.administrator-select').chosen();
			});
		});
		//Submitting ajax request for saving roles
		$('.adminRoles-actContainer-SaveMenuButton').live('click', function() {
			var include = "library/capsule/admin/admin.main.php";
			var idDelLi = $('.deletedMenuList').val();
			var currentDomain = $('.administrator-select-global-site-role').val();
			//console.log(currentDomain);
			var id = getInputDataFromTableRow('#admin-menuSet tbody');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				delMenuList: idDelLi,
				mainID: currentDomain,
				incl: include,
				control: 'admin/saveRoles'
			}, function(data) {
				notificationCenter("Roles saved!");
				$('.admin-popUpMenu').html(data);
				$('.administrator-select').chosen({
					include_group_label_in_selected: true
				});
			});
		});
		//Submmiting ajax request for saving the new content
		$('.adminContent-actContainer-SaveMenuButton').live('click', function() {
			if (notContent != 'Y') {
				deletedContentChecker();
			} else {
				deletedFileChecker();
			}
			var isContentList = $('.contentTable').length;
			if (isContentList != 0) {
				updateNewContentData();
			}
			var text = $('.adminContent-menuChooser').find('option:selected').text();
			var type = $('.adminContent-menuChooser').val();
			var fold = $('.adminContentHeader').val();
			var cat = $('#contentCategorySelected').val();
			var pag = $('#contentPagesSelected').val();
			var pub = $('#contentPublishedSelected').val();
			var lang = $('#contentLanguageSelected').val();
			var include = "library/capsule/admin/admin.main.php";
			var cek = $('.admin-popUpMenu .adminContent-menuChooser').find('option:selected').text();
			if (cek == 'All') {
				return false;
			}
			if (cek != 'Content') {
				if (notContent != 'Y') {
					$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
						folder: fold,
						type: text,
						category: cat,
						pages: pag,
						published: pub,
						incl: include,
						control: 'admin/uploadFile'
					}, function(data) {
						notificationCenter(data.message);
						if (data.lastID != '') {
							$('#file_upload').uploadifySettings('scriptData', {
								'myFolder': $('.adminContentHeader').val()
							});
							$('#file_upload').uploadifyUpload();
						}
					});
				} else {
					var id = $('#editNotContentID').val();
					var oldName = $('#editNotContentOldName').val();
					$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
						id: id,
						oldName: oldName,
						folder: fold,
						type: text,
						category: cat,
						pages: pag,
						published: pub,
						incl: include,
						control: 'admin/uploadEditFile'
					}, function(data) {
						notificationCenter(data.message);
						$('#editNotContentOldName').val(fold);
						if (data.lastID != '') {
							$('#file_upload').uploadifySettings('scriptData', {
								'myFolder': $('.adminContentHeader').val()
							});
							$('#file_upload').uploadifyUpload();
							reloadNotContent(text, '.contentNotContent table');
						}
					});
				}
			} else {
				var contentBody = nicEditors.findEditor('textAreaContent').getContent();
				if (editable == 'Y') {
					var control = 'admin/editInternalContent';
				} else {
					var control = 'admin/submitInternalContent';
				}
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: contentID,
					header: fold,
					content: contentBody,
					category: cat,
					pages: pag,
					published: pub,
					language: lang,
					incl: include,
					control: control
				}, function(data) {
					if (data == 'Content saved') {
						notificationCenter(data);
						$('#adminMenuSet a[core="content"]').trigger('click');
						editable = '';
						contentID = '';
					} else {
						notificationCenter(data);
					}
				});
			}
		});
		//Creating admin menu set table on the fly
		$('#admin-menuSet tbody tr input[type=text]').live('keyup', function() {
			var value = $(this).val();
			var idRow = $(this).parent().parent().find('input[type=checkbox]').val();
			var before = $('.admin-popUpMenu select.admin-menuChooser option[value=' + idRow + ']').val();
			var final = $('.admin-popUpMenu table[myTurn=' + idRow + ']');
			$('.admin-popUpMenu select.admin-menuChooser option[value=' + idRow + ']').replaceWith('<option value="' + before + '" tableID="' + before + '-' + value + '">- ' + value + '</option>');
			$(final).attr('id', before + '-' + value);
		});
		//Creating new row when administrator click plus sign
		$('.admin-actContainer-addMenuButton').live('click', function() {
			var whereAmI = $('.admin-popUpMenu table:visible').attr('class');
			var hereIAm = $('.admin-popUpMenu table:visible');
			if (whereAmI == 'admin-MenuSet') {
				var idMenuSet = $('#admin-menuSet tbody tr:last input[type=checkbox]').val();
				if (idMenuSet == undefined) {
					idMenuSet = 0;
				}
				var idMenuSet = parseInt(idMenuSet) + 1;
				var currentDomain = $('.administrator-select-global-site-menu').val();
				$(hereIAm).find('tbody').append(addTableRowToMenuSet(idMenuSet, currentDomain));
				var myNewTableID = addTableRowMenuSetCreateMenuListTable(idMenuSet);
				$('.admin-popUpMenu').append(myNewTableID);
				$('.admin-popUpMenu table#' + idMenuSet).hide();
				$('.admin-popUpMenu select.admin-menuChooser').append('<option tableid="' + idMenuSet + '" value="' + idMenuSet + '">- </option>');
			} else if (whereAmI == 'admin-subSitesSet') {
				return false;
			} else if (whereAmI == 'admin-sitesSet') {
				//var tr = $(hereIAm).find('tbody tr:last').html();
				var parentSubDomain = $('.administrator-select-global-site').val();
				var tr = '<td class="admin-checkBox"><input type="checkbox" value=""></td><td><input class="admin-inputInherit" type="text" value=""></td><td><input class="admin-inputInherit" type="text" value=""></td><td><select class="select-chosen"><option value="bbpadi.com">bbpadi.com</option><option value="core">core</option><option value="corn.dev">corn.dev</option><option value="localhost">localhost</option></select></td><td><select class="select-chosen"><option value="en">English</option><option value="id">Indonesia</option></select></td><td><select class="select-chosen"><option value="0">Inactive</option><option selected="selected" value="1">Active</option><option value="2">Suspended</option></select></td><td><input type="hidden" value="' + parentSubDomain + '"></td>';
				$(hereIAm).find('tbody tr:last').after('<tr>' + tr + '</tr>');
				//$(hereIAm).find('tbody tr:last input').val('');
				//$(hereIAm).find('tbody tr:last .parentOfSubdomain').val(parentSubDomain);
			} else if (whereAmI == 'contentTable') {
				contentChooser('.admin-popUpMenu table:visible');
			} else if (whereAmI == 'admin-tagonomySet') {
				var currentDomain = $('.administrator-select-global-site-tagonomy').val();
				currentDomain = (typeof currentDomain === 'undefined') ? '' : currentDomain;
				$(hereIAm).find('tbody').append(addTableRowToMenuSetWithEmptyID(currentDomain));
			} else if (whereAmI == 'admin-userSet') {
				$('.admin-popUpMenu table').hide();
				toggleFx();
				$('.admin-second-actionbar').hide('fast', function() {
					editUser(null);
					toggleFx();
				});
			} else if (whereAmI == 'admin-roleSet') {
				var tr = $(hereIAm).find('tbody tr:last').html();
				var parentSubDomain = $('.administrator-select-global-site-role ').val();
				$(hereIAm).find('tbody tr:last').after('<tr>' + tr + '</tr>');
				$(hereIAm).find('tbody tr:last input').val('');
				$(hereIAm).find('tbody tr:last .parentOfSubdomain').val(parentSubDomain);
			} else {
				var id = $('.admin-popUpMenu select.admin-menuChooser').find(':selected').val();
				var last = $('.admin-popUpMenu table:visible tbody tr:last').find('input[type=checkbox]').val();
				if (last == undefined) {
					var lastIDToInsert = 1;
					lastID = 'insert-' + lastIDToInsert;
				} else {
					last = last.replace('insert-', '');
					var lastIDToInsert = parseInt(last) + 1;
					lastID = 'insert-' + lastIDToInsert;
				}
				$(hereIAm).find('tbody').append(addTableRowMenuList(id, lastID));
			}
			$('.administrator-select').chosen({
				allow_single_deselect: true
			});
		});
		//Deleting row when administrator click minus sign
		$('.admin-actContainer-delMenuButton').live('click', function() {
			$('.admin-popUpMenu table tbody tr:visible input:checked').each(function() {
				var id = $(this).val();
				var val = $('.deletedMenuList').val();
				var val2 = $('.deletedMenuSet').val();
				var content = $('#contentPlace').length;
				if ($('.admin-popUpMenu table:visible').attr('class') == 'admin-MenuSet') {
					$('.deletedMenuSet').val(val2 + '' + id + ',');
					$('.admin-popUpMenu select.admin-menuChooser option[value=' + id + ']').remove();
					$('.admin-popUpMenu table[myTurn=' + id + ']').remove();
				} else {
					if (content != 1) {
						$('.deletedMenuList').val(val + '' + id + ',');
					} else if (notContent == 'Y') {
						$('.deletedMenuList').val(val + '' + id + ',');
					} else {
						var type = $(this).parent().parent().find('img[finder="here"]').attr('type');
						$('.deletedMenuList').val(val + '' + id + '/' + type + ',');
					}
				}
			});
			if (notContent != 'Y') {
				$('.admin-popUpMenu table tbody tr:visible input:checked').parent().parent().remove();
			} else {
				$('.admin-popUpMenu table tbody tr:visible input:checked').parent().remove();
			}
		});
		//Event listener for admin-popUpMenu when change selection
		$('.admin-popUpMenu select.admin-menuChooser').live('change', function() {
			var check = $(this).find('option:selected').text();
			var theID = $(this).find(':selected').attr('tableID');
			$('.admin-popUpMenu table').hide();
			$('.admin-popUpMenu table#' + theID).show();
			if (check != 'Menu Set') {
				$('.admin-languageSelect').show();
				$('.admin-second-actionbar').hide();
			} else {
				$('.admin-languageSelect').hide();
				$('.admin-second-actionbar').show();
			}
			$('.admin-languageSelect select').chosen();
		});
		//Event listener for admin-popUpMenu when change selection
		$('.administrator-select-global-site-menu').live('change', function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $(this).val();
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getMenuList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.administrator-select-global-site-user').live('change', function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $(this).val();
			//console.log(currentDomain);
			//$('#container-user').remove();
			//$('.admin-popUpMenu').append('<div class="#container-user"></div>');
			//$('#container-user').centerOnly();
			//$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getUserList'
			}, function(data) {
				$('#container-user').replaceWith(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.prev-adminPagging').attr("disabled", "disabled");
				if ($('.total-adminPagging').val() <= 1) {
					$('.next-adminPagging').attr("disabled", "disabled");
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.administrator-select-global-site-role').live('change', function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $(this).val();
			//console.log(currentDomain);
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getRoleList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		//Event listener for admin-popUpMenu when change selection
		$('.administrator-select-global-site-tagonomy').live('change', function() {
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $(this).val();
			//console.log(currentDomain);
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				mainID: currentDomain,
				incl: include,
				control: 'admin/getTagonomyList'
			}, function(data) {
				$('.admin-popUpMenu').html(data);
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.administrator-select').chosen();
			});
		});
		$('.administrator-jumpToPage').live('change', function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain;
			var getParam = $(this).attr('rel');
			switch (getParam) {
			case 'menu':
				control = 'admin/getMenuList';
				currentDomain = $('.administrator-select-global-site-menu').val();
				break;
			case 'user':
				control = 'admin/getUserList';
				currentDomain = $('.administrator-select-global-site-user').val();
				break;
			case 'tagonomy':
				control = 'admin/getTagonomyList';
				currentDomain = $('.administrator-select-global-site-tagonomy').val();
				break;
			case 'role':
				control = 'admin/getRoleList';
				currentDomain = $('.administrator-select-global-site-role').val();
				break;
			case 'site':
				control = 'admin/getSubSitesList';
				currentDomain = $('.administrator-select-global-site').val();
				break;
			case 'subsite':
				control = 'admin/getSubSitesList';
				currentDomain = $('.administrator-select-global-site').val();
				break;
			default:
				control = null;
				break;
			}
			//console.log(currentDomain);
			var nextPage = $(this).val();
			if (getParam == 'site' || getParam == 'subsite') {
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					idSites: currentDomain,
					nextPage: nextPage,
					incl: include,
					control: control
				}, function(result) {
					$('.admin-sitesSet').html(result);
					var totalPage = $('.total-adminPagging').val();
					totalPage = parseInt(totalPage);
					var currentPage = $('.curent-adminPagging').val();
					currentPage = parseInt(currentPage);
					if (totalPage > 1 && currentPage <= totalPage) {
						$('.next-adminPagging').removeAttr("disabled");
					} else {
						$('.next-adminPagging').attr("disabled", "disabled");
						$('.next-adminPagging').click(false);
					}
					if (currentPage > 1 && currentPage <= totalPage) {
						$('.prev-adminPagging').removeAttr("disabled");
					} else {
						$('.prev-adminPagging').attr("disabled", "disabled");
						$('.prev-adminPagging').click(false);
					}
					//console.log($('.total-adminPagging').val());
					//console.log($('.curent-adminPagging').val());
					$('.administrator-select').chosen();
				});
			} else {
				$('.admin-popUpMenu').remove();
				$('body').append('<div class="admin-popUpMenu"></div>');
				$('.admin-popUpMenu').centerOnly();
				$('.admin-popUpMenu').html('Loading...');
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					nextPage: nextPage,
					mainID: currentDomain,
					incl: include,
					control: control
				}, function(data) {
					$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
					var totalPage = $('.total-adminPagging').val();
					totalPage = parseInt(totalPage);
					var currentPage = $('.curent-adminPagging').val();
					currentPage = parseInt(currentPage);
					if (totalPage > 1 && currentPage <= totalPage) {
						$('.next-adminPagging').removeAttr("disabled");
					} else {
						$('.next-adminPagging').attr("disabled", "disabled");
						$('.next-adminPagging').click(false);
					}
					if (currentPage > 1 && currentPage <= totalPage) {
						$('.prev-adminPagging').removeAttr("disabled");
					} else {
						$('.prev-adminPagging').attr("disabled", "disabled");
						$('.prev-adminPagging').click(false);
					}
					$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
					$('.admin-menuChooser').chosen();
					$('.administrator-select').chosen();
					$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
						id: language,
						incl: include,
						control: 'admin/getLanguage'
					}, function(lang) {
						$('.admin-languageSelect').html(lang).hide();
						$('.admin-languageSelect select').chosen();
					});
				});
			}
		});
		$('.next-adminPagging-user').live("click", function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $('.administrator-select-global-site-user').val();
			//console.log(currentDomain);
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) + 1;
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				nextPage: nextPage,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getUserList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				if ($('.total-adminPagging').val() > 1 && $('.curent-adminPagging').val() <= $('.total-adminPagging').val()) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if ($('.total-adminPagging').val() >= 1 && $('.curent-adminPagging').val() >= 1 && $('.curent-adminPagging').val() <= $('.total-adminPagging').val()) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.prev-adminPagging-user').live("click", function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $('.administrator-select-global-site-user').val();
			//console.log(currentDomain);
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) - 1;
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				nextPage: nextPage,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getUserList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.next-adminPagging-menu').live("click", function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $('.administrator-select-global-site-menu').val();
			//console.log(currentDomain);
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) + 1;
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				nextPage: nextPage,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getMenuList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.prev-adminPagging-menu').live("click", function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $('.administrator-select-global-site-menu').val();
			//console.log(currentDomain);
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) - 1;
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				nextPage: nextPage,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getMenuList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.next-adminPagging-tag').live("click", function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $('.administrator-select-global-site-tagonomy').val();
			//console.log(currentDomain);
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) + 1;
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				nextPage: nextPage,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getTagonomyList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.prev-adminPagging-tag').live("click", function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $('.administrator-select-global-site-tagonomy').val();
			//console.log(currentDomain);
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) - 1;
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				nextPage: nextPage,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getTagonomyList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.next-adminPagging-role').live("click", function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $('.administrator-select-global-site-role').val();
			//console.log(currentDomain);
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) + 1;
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				nextPage: nextPage,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getRoleList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.prev-adminPagging-role').live("click", function() {
			var language = $('.admin-languageSelect select').val();
			var include = "library/capsule/admin/admin.main.php";
			var currentDomain = $('.administrator-select-global-site-role').val();
			//console.log(currentDomain);
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) - 1;
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				nextPage: nextPage,
				mainID: currentDomain,
				incl: include,
				control: 'admin/getRoleList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		$('.prev-adminPagging-sites').live('click', function() {
			var check = $('.administrator-select-global-site').find('option:selected').val();
			var include = "library/capsule/admin/admin.main.php";
			//var theID = $(this).find(':selected').attr('tableID');
			//$('.admin-popUpMenu table').hide(); $('.admin-popUpMenu table#'+theID).show();
			//if (check != 'Sites Set') {
			//$('.admin-languageSelect').show();
			//}
			//else {
			//$('.admin-languageSelect').hide();
			//}
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) - 1;
			//console.log(check);
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				idSites: check,
				nextPage: nextPage,
				incl: include,
				control: 'admin/getSubSitesList'
			}, function(result) {
				$('.admin-sitesSet').html(result);
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.administrator-select').chosen();
			});
		});
		$('.next-adminPagging-sites').live('click', function() {
			var check = $('.administrator-select-global-site').find('option:selected').val();
			var include = "library/capsule/admin/admin.main.php";
			var nextPage = $('.curent-adminPagging').val();
			nextPage = parseInt(nextPage) + 1;
			//console.log(check);
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				idSites: check,
				nextPage: nextPage,
				incl: include,
				control: 'admin/getSubSitesList'
			}, function(result) {
				$('.admin-sitesSet').html(result);
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.administrator-select').chosen();
			});
		});
		//Event listener for admin-popUpMenu when change selection
		$('.admin-popUpMenu select.administrator-select-global-site').live('change', function() {
			var check = $(this).find('option:selected').val();
			var include = "library/capsule/admin/admin.main.php";
			//var theID = $(this).find(':selected').attr('tableID');
			//$('.admin-popUpMenu table').hide(); $('.admin-popUpMenu table#'+theID).show();
			//if (check != 'Sites Set') {
			//$('.admin-languageSelect').show();
			//}
			//else {
			//$('.admin-languageSelect').hide();
			//}
			//console.log(check);
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				idSites: check,
				incl: include,
				control: 'admin/getSubSitesList'
			}, function(result) {
				$('.admin-sitesSet').html(result);
				var totalPage = $('.total-adminPagging').val();
				totalPage = parseInt(totalPage);
				var currentPage = $('.curent-adminPagging').val();
				currentPage = parseInt(currentPage);
				if (totalPage > 1 && currentPage <= totalPage) {
					$('.next-adminPagging').removeAttr("disabled");
				} else {
					$('.next-adminPagging').attr("disabled", "disabled");
					$('.next-adminPagging').click(false);
				}
				if (currentPage > 1 && currentPage <= totalPage) {
					$('.prev-adminPagging').removeAttr("disabled");
				} else {
					$('.prev-adminPagging').attr("disabled", "disabled");
					$('.prev-adminPagging').click(false);
				}
				$('.administrator-select').chosen();
			});
		});
		//Event listener for =admin-languageSelect select when change selection
		$('.admin-languageSelect select').live('change', function() {
			var language = $(this).val();
			var include = "library/capsule/admin/admin.main.php";
			$('.admin-popUpMenu').remove();
			$('body').append('<div class="admin-popUpMenu"></div>');
			$('.admin-popUpMenu').centerOnly();
			$('.admin-popUpMenu').html('Loading...');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: language,
				incl: include,
				control: 'admin/getMenuList'
			}, function(data) {
				$('.admin-popUpMenu').html(data); //var theID = $('.admin-popUpMenu select').find(':selected').attr('tableID');
				$('.admin-popUpMenu table:not(#admin-menuSet)').hide(); //$('.admin-popUpMenu table#'+theID).show();		
				$('.admin-menuChooser').chosen();
				$('.administrator-select').chosen();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: language,
					incl: include,
					control: 'admin/getLanguage'
				}, function(lang) {
					$('.admin-languageSelect').html(lang).hide();
					$('.admin-languageSelect select').chosen();
				});
			});
		});
		//Event listener for adminContent-popUpMenu when change selection
		$('.admin-popUpMenu .adminContent-menuChooser').live('change', function() {
			var check = $(this).find('option:selected').text();
			$('.contentChangeable').find('div').remove();
			if (check != 'Content') {
				$('.contentChangeable').html(newNotContent);
				$('#file_upload').uploadify({
					'uploader': 'library/plugins/uploadifyOld/uploadify.swf',
					'script': '/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php',
					'cancelImg': 'library/plugins/uploadifyOld/uploadify-cancel.png',
					'auto': false,
					'multi': true,
					'buttonText': 'Select Files',
					'scriptData': {
						"control": 'admin/uploadItem',
						"type": check,
						"incl": 'library/capsule/admin/admin.main.php',
						"myFolder": $('.adminContentHeader').val(),
					},
					'onComplete': function(event, ID, fileObj, response, data) {
						notificationCenter(response);
						//alert('There are ' + data.fileCount + ' files remaining in the queue.');
					}
				});
			} else {
				$('.contentChangeable').html(contentContent());
			}
		});
		//Event handler for when content image row is clicked
		$('.adminContentList').live('click', function() {
			editContent($(this).parent().parent());
		});
		var toggleFx = function() {
				$.fx.off = !$.fx.off;
			};
		//Event handler for when user image row is clicked
		$('.adminUserDetail').live('click', function() {
			var a = $(this);
			$('table').hide();
			toggleFx();
			$('.admin-second-actionbar').hide('fast', function() {
				editUser(a);
				toggleFx();
			});
		});
		//Container event listener for droppable capsule
		$(".capsuleContainer").droppable({
			hoverClass: "capsuleContainerHover",
			accept: ".dragCapsule",
			drop: function(e, ui) {
				var overlay = $('#overlay').length;
				var thisCon = this;
				var idCapsule = $(ui.helper).find('.capid').val();
				var inCapsule = $(ui.helper).find('.capincl').val();
				var include = "library/capsule/admin/admin.main.php";
				var includecap = inCapsule;
				if (idCapsule != undefined && overlay == 0) {
					$(this).text('Loading…');
					$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
						incl: include,
						includecap: includecap,
						idCapsule: idCapsule,
						control: 'admin/loadCapsule'
					}, function(data) {
						$(thisCon).html('<input type="hidden" name="capsuleID" value="' + idCapsule + '"><input type="hidden" name="capsuleID" value="' + inCapsule + '">' + data);
					});
				}
			}
		});
		//Event listener for canceling the optionGearPopUp
		$('.capCancelOption').live('click', function() {
			$('.optionGearPopUp, #overlay').remove();
			$('body').find('.capsuleContainerHover').removeClass('capsuleContainerHover');
		});
		//Event listener for submitting capsule option
		$('.capSubmitOption').live('click', function() {
			var arrayCon = [];
			var thisCon = $('.capsuleContainerHover');
			var idCapsule = $(this).parent().find('input[type=hidden]').val();
			var include = "library/capsule/admin/admin.main.php";
			$(thisCon).text('Loading…');
			$('.displayCapsuleOptionContent tr').each(function(i) {
				var header = $(this).find('.optionHeader').text();
				var content = $(this).find('.optionContent').children();
				if (content.is('input')) {
					var contentValue = $(content).val();
				} else if (content.is('select')) {
					var contentValue = $(content).find(':selected').val();
				}
				arrayCon[i] = {};
				arrayCon[i][header] = contentValue;
			});
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				incl: include,
				arrayCon: arrayCon,
				idCapsule: idCapsule,
				control: 'admin/loadCapsuleWithOption'
			}, function(data) {
				$(thisCon).html('<input type="hidden" name="capsuleID" value="' + idCapsule + '">' + data);
			});
			$('.optionGearPopUp, #overlay').remove();
			$('body').find('.capsuleContainerHover').removeClass('capsuleContainerHover');
		});
		//optionGearContent Row Table Handler
		$('.optionGearContent table tr').live('hover', function() {
			if ($(this).attr('class') != 'unHoverable') {
				$(this).toggleClass('optionGearContentTableHover');
			}
		});
		//Event listener for option gear
		$('.optionGear').live('click', function() {
			//DOM when option gear is clicked 
			var optionGearActive = "<div class='optionGearContent'><table><tr><td class='optionGearContentImg'><img class='optionGearImage' src='/cornc/library/capsule/admin/image/delete.png'/></td><td class='optionGearContentAct'>Delete</td><tr class='unHoverable'><td colspan='2'><hr /></td></tr><tr><td><img class='optionGearImage' src='/cornc/library/capsule/admin/image/settingCap.png'/></td><td class='optionGearContentAct'>Option</td></table></div>";
			var position = $(this).offset();
			var whereAmI = $(this).parent().parent();
			$('.optionGearContent').remove();
			$('.optionGear').removeClass('optionGearActive');
			$(whereAmI).prepend(optionGearActive);
			//alert($(this).length);
			$(this).addClass('optionGearActive');
			//$('.optionGearContent').css("top", position.top + 15 + "px").css("left", position.left - 95 + "px");
		});
		//Event listener for option gear content 
		$('.optionGearContent table tr').live('click', function() {
			var choose = $(this).find('td').text();
			if (choose == 'Option') {
				var overlay = $('<div id="overlay"></div>');
				var include = "library/capsule/admin/admin.main.php";
				var id = $(this).parent().parent().parent().parent().parent().find('input[name=capsuleID]').val();
				var check1 = $(this).parent().parent().parent().parent().parent().find('.capsuleContainer').length;
				if (check1 != 1) {
					$(this).parent().parent().parent().parent().parent().addClass('capsuleContainerHover');
				} else {
					$(this).parent().parent().parent().parent().parent().find('.capsuleContainer').addClass('capsuleContainerHover');
				}
				$('.optionGear').removeClass('optionGearActive');
				$('.optionGearContent').remove();
				overlay.appendTo(document.body);
				$('body').append('<div class="optionGearPopUp">Loading…</div>');
				$('.optionGearPopUp').center();
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: id,
					incl: include,
					control: 'admin/capsuleOption'
				}, function(data) {
					$('.optionGearPopUp').html('<input type="hidden" value="' + id + '">' + data);
					$('.optionGearPopUp').center();
				});
			}
		});
		//Ajax event when the user click save button on the text area
		$('.contentSubmit').live('click', function() {
			if ($('.contentSubmit').html() != 'Save') {
				return false;
			}
			$(this).empty().html('<img class="buttonAjaxLoader" src="library/capsule/admin/image/ajax-loaderHover.gif" />');
			var pageID = $('input[name=pageID]').val();
			var menuID = $('input[name=menuID]').val();
			var language = $('input[name=contentLanguageDeterminator]').val();
			var languageSet = $('#languageSelectMain').val();
			var contentHead = $('input[name=myContentHeader]').val();
			var pagePath = $('input[name="pagePathToFile"]').val();
			var contentBody = nicEditors.findEditor('myTextarea').getContent();
			var tableName = "CAP_CONTENT";
			var whereColumn = "CAP_CON_ID";
			var include = "library/capsule/admin/admin.main.php";
			var columnValue = {};
			if (pageID != '') {
				columnValue["CAP_CON_HEADER"] = contentHead;
				columnValue["CAP_CON_CONTENT"] = contentBody;
			} else {
				columnValue["CAP_USER_CAP_USE_ID"] = '';
				columnValue["FK_CAP_CONTENT_CATEGORY"] = '';
				columnValue["CAP_CON_CREATED"] = '';
				columnValue["CAP_CON_PUBLISHED"] = 'Y';
				columnValue["CAP_CON_PAGES"] = pagePath;
				columnValue["CAP_CON_HEADER"] = contentHead;
				columnValue["CAP_CON_CONTENT"] = contentBody;
				//columnValue ["FK_CAP_CONTENT_TYPE"] 	= 1;
			}
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: pageID,
				menuID: menuID,
				language: language,
				languageSet: languageSet,
				tableName: tableName,
				whereColumn: whereColumn,
				incl: include,
				pageArray: columnValue,
				control: 'admin/submitContent'
			}, function(data) {
				try {
					res = $.parseJSON(data);
				} catch (e) {
					alert("Error! Cannot save at this time. Check console log.");
					console.log(data);
					return false;
				}
				if (res.response == 'Content saved') {
					$('.contentSubmit').html('Save');
					$('input[name=contentLanguageDeterminator]').val(res.language);
					var val = $('input[name=pageID]').val();
					if (val == '') {
						$('input[name=pageID]').val(res.pageID);
					}
				} else {
					$('.contentSubmit').html('Save');
				}
			});
		});
		var head = $('.contentHeader').html();
		var body = $('.contentBody').html();
		var visi = $('#adminContainer').length;
		if (visi == 1) {
			//$('#adminContainer').hide();
			$('.contentHeader').html('<div id="myContentHeaderContainer"><input class="myContentHeader" type="text" name="myContentHeader" value="' + head + '"><button class="contentSubmit">Save</button></div>');
			$('.contentBody').html('<div id="nicPanel"></div><textarea id="myTextarea">' + body + '</textarea>');
			$('#myTextarea').elastic();
			//$('#adminContainer').slideDown('slow');
		}
		if ($('#myTextarea').length != 0) {
			var path = $('#adminContainer').attr('data-folder');
			bkLib.onDomLoaded(function() {
				var myNicEditor = new nicEditor({
					iconsPath: '/' + path + '/library/plugins/nicEdit/nicEditorIcons.gif',
					buttonList: ['bold', 'italic', 'underline', 'left', 'center', 'right', 'justify', 'ol', 'ul', 'fontSize', 'fontFamily', 'fontFormat', 'image', 'link', 'forecolor', 'xhtml']
				});
				myNicEditor.setPanel('nicPanel');
				myNicEditor.addInstance('myTextarea');
			});
		}
		$('.admin-image-link').live('click', function() {
			var link = $(this).attr('value');
			notificationCenter(link);
		});
		//The event listener for metadata CRUD
		$('.admin-image-metadata').live('click', function() {
			$('.admin-metadata-container').remove();
			$('body').append('<div class="admin-metadata-container"></div>');
			$('.admin-metadata-container').hide();
			var id = $(this).attr('value');
			var idData = $(this).attr('id');
			var include = "library/capsule/admin/admin.main.php";
			var position = $(this).offset();
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				idData: idData,
				incl: include,
				control: 'admin/metadata'
			}, function(data) {
				$('.admin-metadata-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
			});
		});
		var adminMetadataDeleter = [];
		$('.admin-administrator-itemDetailDeler').live('click', function() {
			$('.admin-administrator-content-metadata tr input[type=checkbox]:checked').each(function(i) {
				if ($(this).val() != 'on') {
					adminMetadataDeleter[i] = $(this).val();
				}
			});
			$('.admin-administrator-content-metadata tr input[type=checkbox]:checked').parent().parent().remove();
		});
		$('.admin-administrator-itemDetailAdder').live('click', function() {
			var id = $('.admin-administrator-content-metadata tbody tr:first').find('.admin-hidden-metadata-idData').val();
			var path = $('.admin-administrator-content-metadata tbody tr:first').find('.admin-hidden-metadata-realPath').val();
			$('.admin-administrator-content-metadata tr:last').after("<tr><td><input type='checkbox'></td><td><input class='admin-hidden-metadata-idData' type='hidden' value='" + id + "'><input type='text'></td><td><input type='text'><input class='admin-hidden-metadata-realPath' type='hidden' value='" + path + "'></td></tr><tr><td colspan=3><hr></td></tr>");
		});
		$('.admin-administrator-metadataCancel').live('click', function() {
			$('.admin-metadata-container').remove();
		});
		$('.admin-administrator-metadataSubmit').live('click', function() {
			var id = getInputDataFromTableRow('.admin-administrator-content-metadata tbody');
			var include = "library/capsule/admin/admin.main.php";
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				del: adminMetadataDeleter,
				incl: include,
				control: 'admin/saveMetadata'
			}, function(data) {
				adminMetadataDeleter = [];
				$('.admin-metadata-container').remove();
			});
		});
		//All function goes here

		function getInputDataFromTableRowRecursive(tableName) {
			var array = [];
			$('#admin-menuSet tbody').find('tr').each(function(i) {
				array[i] = {};
				array[i]['id'] = $(this).find('input[type=checkbox]').val();
				array[i]['name'] = $(this).find('input[type=text]').val();
				array[i]['domain'] = $(this).find('input[type=hidden]').val()
				array[i]['child'] = getInputDataFromTableRow('.admin-popUpMenu table[myTurn=' + $(this).find('input[type=checkbox]').val() + '] tbody');
			});
			return array;
		}

		function getInputDataFromTableRow(tableName) {
			var array = [];
			$(tableName).find('tr').each(function(i) {
				array[i] = {};
				$(this).find('input,select').each(function(y) {
					var check = $(this).val();
					var value = (typeof check === 'undefined') ? '' :  check;
					array[i][y] = value;
				});
			});
			return array;
		}

		function getInputDataFromForm(formName) {
			var array = {};
			var name = '';
			$(formName).find('input[type=text],input[type=hidden],input[type=password],input[type=checkbox]:checked,select').each(function(i) {
				if ($(this).attr('id') != undefined) {
					array[$(this).attr('id')] = $(this).val();
				}
			});
			return array;
		}

		function setPositionOfAllTheTable(tableName) {
			$(tableName).each(function(i) {
				var lastPadding = 0;
				var lastPosition = 0;
				$(this).find('tbody tr').each(function(y) {
					var padding = $(this).find('.myStyle').attr('padding');
					if (parseInt(padding) != parseInt(lastPadding)) {
						//lastPadding = padding; 
						if (padding == 0) {
							//$(this).parent().find('tr[position!=0]').removeAttr('position');
							$(this).parent().find('tr[position=' + lastPadding + ']').css('background-color', 'red');
							//lastPosition = 1;
							lastPadding = 0;
						} else {
							lastPadding = padding;
							//$(this).parent().find('tr[position='+lastPadding+']').removeAttr('position');
							lastPadding = padding;
						}
						var my = $(this).parent().find('tr[position=' + lastPadding + '] input[name=position]').val();
						var ah = $(this).parent().find('tr').eq(y - 1).find('.myStyle').attr('padding');
						$(this).parent().find('tr').eq(y - 1).attr('position', ah);
						if (!isNaN(my)) {
							if (padding == 0) {
								lastPosition = parseInt(my) + 1;
							} else {
								lastPosition = parseInt(my) + 1;
							}
						} else {
							lastPosition = 1;
						}
						$(this).find('input[name=position]').val(lastPosition);
						$(this).parent().find('tr[position=' + padding + ']').removeAttr('position');
					} else {
						lastPosition = lastPosition + 1;
						$(this).find('input[name=position]').val(lastPosition);
					}
				});
				$(this).find('tr').removeAttr('position');
			});
		}

		function contentChooser(tableName) {
			$(tableName).remove();
			$('#textAreaContent').remove();
			$('#contentPlace').append(newContent);
			var path = $('#adminContainer').attr('data-folder');
			var myNicEditor = new nicEditor({
				iconsPath: '/' + path + '/library/plugins/nicEdit/nicEditorIcons.gif',
				buttonList: ['bold', 'italic', 'underline', 'left', 'center', 'right', 'justify', 'ol', 'ul', 'fontSize', 'fontFamily', 'fontFormat', 'image', 'link', 'forecolor', 'xhtml']
			});
			myNicEditor.setPanel('theNicPanel');
			myNicEditor.addInstance('textAreaContent')
			$('.adminContent-menuChooser').val(1);
			$('#contentPlace div:last').css('border', '1px solid #b2b2b2');
		}

		function contentContent() {
			$('.contentChangeable').html("<div id='theNicPanel'></div><textarea id='textAreaContent'></textarea>");
			var path = $('#adminContainer').attr('data-folder');
			var myNicEditor = new nicEditor({
				iconsPath: '/' + path + '/library/plugins/nicEdit/nicEditorIcons.gif',
				buttonList: ['bold', 'italic', 'underline', 'left', 'center', 'right', 'justify', 'ol', 'ul', 'fontSize', 'fontFamily', 'fontFormat', 'image', 'link', 'forecolor', 'xhtml']
			});
			myNicEditor.setPanel('theNicPanel');
			myNicEditor.addInstance('textAreaContent')
			$('#contentPlace div:last').css('border', '1px solid #b2b2b2');
		}

		function contentChooser2(tableName) {
			$(tableName).remove();
			$('#textAreaContent').remove();
			$('#contentPlace').append(newContent);
		}

		function addTableRowToMenuSet(id, mainID) {
			if (mainID != undefined) {
				mainID = mainID;
			} else {
				mainID = document.domain;
			}
			//console.log(mainID);
			var rowStyle = '<tr><td><input type="checkbox" value="' + id + '"></td><td><input class="admin-inputInherit" type="text"><input type="hidden" value="' + mainID + '"></td></tr>';
			return rowStyle;
		}

		function addTableRowToMenuSetWithEmptyID(parentSubDomain) {
			var rowStyle = '<tr><td><input type="checkbox" value=""></td><td><input class="admin-inputInherit" type="text"><input type="hidden" value="' + parentSubDomain + '"></td></tr>';
			return rowStyle;
		}

		function addTableRowMenuSetCreateMenuListTable(id) {
			var rowStyle = '<table class="admin-MenuList" myTurn=' + id + ' id="' + id + '"><thead><tr><td class="admin-checkBox"><img src="library/capsule/admin/image/list.png"></td><td class="admin-checkBox"><input type="checkbox"></td><td>Name</td><td class="optionCenter">Access</td><td class="optionCenter">Status</td><td class="optionCenter">Pages</td></tr></thead><tbody></tbody></table>';
			return rowStyle;
		}

		function addTableRowMenuList(id, lastID) {
			var rowStyle = '"<tr class="draggableMenu"><td class="admin-draggableHandler"><img src="library/capsule/admin/image/list.png"></td><td><input type="checkbox" value=' + lastID + '></td><td class="myStyle" padding="0" style="padding-left:0px"><input class="admin-inputInherit" type="text"></td><td><input class="admin-menu-class" type="text" value=""></td><td><input class="admin-menu-class" type="text" value=""></td><td><input class="admin-menu-class" type="text" value=""></td><td class="optionCenter">' + RoleList + '</td><td class="optionCenter"><select class="admin-menu-class"><option value="Active" selected="selected">Active</option><option value="Inactive">Inactive</option><input type="hidden" value=' + id + '></select></td><td class="optionCenter"><input name="parentID" type="hidden">' + PagesList + '<input name="position" type="hidden" value=""></td></tr>';
			return rowStyle;
		}

		function elementDeterminator(elementName) {
			var result;
			var content = $(elementName).children();
			if (content.is('input')) {
				var contentValue = $(content).val();
			} else if (content.is('select')) {
				var contentValue = $(content).find(':selected').val();
			}
			return result;
		}

		function notificationCenter(notification) {
			var container = "<div class='globalNotificationCenter'>" + notification + "</div>";
			$('.globalNotificationCenter').remove();
			$('body').append(container);
			$('.globalNotificationCenter').hide().fadeIn('slow', function() {
				setTimeout(function() {
					$('.globalNotificationCenter').fadeOut(3000);
				}, 5000);
			});
		}

		function editUser(user) {
			var include = "library/capsule/admin/admin.main.php";
			var id = $(user).parent().parent().find('input[type=checkbox]').val();
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				incl: include,
				control: 'admin/getUserToEdit'
			}, function(data) {
				$('#admin-userContainer').html(data);
				$('.administrator-select').chosen({
					allow_single_deselect: true
				});
				$('.administrator-select-global-site').parent().find('.chzn-container').attr('style', 'display:none;');
				$('.administrator-input-global-site').removeAttr('style');
				$('.administrator-checkbox-global').live('click', function() {
/*$('.administrator-select-global-site').toggleClass('administrator-select');
		$('.administrator-select-global-site').parent().find('.chzn-container').toggleClass('chzn-disabled');
		$('.administrator-select-global-site').parent().find('.chzn-container').toggleClass('chzn-container-active');*/
					var check = $(this).attr('checked');
					//console.log(check);
					if (check == 'checked') {
						$('.administrator-select-global-site').parent().find('.chzn-container').removeAttr('style');
						$('.administrator-select-global-site').parent().find('.chzn-container').attr('style', 'width: 220px;');
						$('.administrator-input-global-site').attr('style', 'display:none;');
					} else {
						$('.administrator-input-global-site').removeAttr('style');
						$('.administrator-select-global-site').parent().find('.chzn-container').attr('style', 'display:none;width: 220px;');
					}
				});
			});
		}

		function editContent(table) {
			var check = $(table).find('img[finder=here]').attr('type');
			var id = $(table).find('input[type=checkbox]').val();
			var include = "library/capsule/admin/admin.main.php";
			if (check == 'content') {
				contentController(id, '.admin-popUpMenu table:visible');
			} else {
				notContentController(id, check, '.admin-popUpMenu table:visible');
			}
		}
		//var myExtraordinaryID;
		$('#contentLanguageSelected').live('change', function() {
			contentControllerAjax(contentID, $(this).val());
		});
		$('.admin-checkBox input[type=checkbox]').live('click', function() {
			var check = $(this).attr('checked');
			if (check == 'checked') {
				$('table.contentTable tbody input[type=checkbox]').attr('checked', true);
			} else {
				$('table.contentTable tbody input[type=checkbox]').attr('checked', false);
			}
		});

		function contentControllerAjax(id, lang) {
			var include = "library/capsule/admin/admin.main.php";
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				lang: lang,
				incl: include,
				control: 'admin/getContentToEditAjax'
			}, function(data) {
				$('.adminContentHeader').val('');
				$('.nicEdit-main').html('');
				$('.adminContentHeader').val(data.header);
				$('.nicEdit-main').html(data.content);
			});
		}

		function contentController(id, tableName) {
			var include = "library/capsule/admin/admin.main.php";
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				incl: include,
				control: 'admin/getContentToEdit'
			}, function(data) {
				$(tableName).remove();
				myExtraordinaryID = data.id;
				$('#contentPlace').append(newContent);
				$('#contentLanguageSelected').val(data.language);
				$('#contentPagesSelected').val(data.pages);
				$('#contentPublishedSelected').val(data.published);
				$('#contentCategorySelected').val(data.category);
				$('.adminContentHeader').val(data.header);
				$('#textAreaContent').html(data.content);
				$('.adminContent-menuChooser').val(1);
				editable = 'Y';
				contentID = data.id;
				var path = $('#adminContainer').attr('data-folder');
				var myNicEditor = new nicEditor({
					iconsPath: '/' + path + '/library/plugins/nicEdit/nicEditorIcons.gif',
					buttonList: ['bold', 'italic', 'underline', 'left', 'center', 'right', 'justify', 'ol', 'ul', 'fontSize', 'fontFamily', 'fontFormat', 'image', 'link', 'forecolor', 'xhtml']
				});
				myNicEditor.setPanel('theNicPanel');
				myNicEditor.addInstance('textAreaContent')
				$('#contentPlace div:last').css('border', '1px solid #b2b2b2');
			});
		}

		function notContentController(id, check, tableName) {
			$(tableName).remove();
			var include = "library/capsule/admin/admin.main.php";
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				type: check,
				incl: include,
				control: 'admin/getFileToEdit'
			}, function(data) {
				$('#contentPlace').html(editNotContent);
				$('#contentPagesSelected').val(data.pages);
				$('#contentPublishedSelected').val(data.published);
				$('#contentCategorySelected').val(data.category);
				$('.adminContentHeader').val(data.name);
				$('.contentNotContent').html(data.view);
				$('.adminContent-menuChooser').val(data.type);
				$('.adminContent-menuChooser').attr('disabled', 'disabled');
				$('#editNotContentID').val(data.id);
				$('#editNotContentOldName').val(data.name);
				$('#file_upload').uploadify({
					'uploader': 'library/plugins/uploadifyOld/uploadify.swf',
					'script': '/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php',
					'cancelImg': 'library/plugins/uploadifyOld/uploadify-cancel.png',
					'auto': false,
					'multi': true,
					'buttonText': 'Select Files',
					'scriptData': {
						"control": 'admin/uploadItem',
						"type": check,
						"incl": 'library/capsule/admin/admin.main.php',
						"myFolder": $('.adminContentHeader').val(),
					},
					'onComplete': function(event, ID, fileObj, response, data) {
						notificationCenter(response);
						//alert('There are ' + data.fileCount + ' files remaining in the queue.');
					}
				});
				notContent = 'Y';
			});
		}

		function reloadNotContent(check, tableName) {
			var id = $('#editNotContentID').val();
			var check = lowerString(check);
			$(tableName).remove();
			var include = "library/capsule/admin/admin.main.php";
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: id,
				type: check,
				incl: include,
				control: 'admin/getFileToEdit'
			}, function(data) {
				$('.contentNotContent').html(data.view).hide();
				$('.contentNotContent').fadeIn('slow');
			});
		}

		function deletedContentChecker() {
			var include = "library/capsule/admin/admin.main.php";
			var checker = $('.deletedMenuList').val();
			if (checker != '') {
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: checker,
					incl: include,
					control: 'admin/deleteContent'
				}, function(data) {
					notificationCenter(data);
				});
			}
		}

		function deletedFileChecker() {
			var include = "library/capsule/admin/admin.main.php";
			var checker = $('.deletedMenuList').val();
			if (checker != '') {
				$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
					id: checker,
					incl: include,
					control: 'admin/deleteFile'
				}, function(data) {
					notificationCenter(data);
				});
			}
		}

		function updateNewContentData() {
			var include = "library/capsule/admin/admin.main.php";
			var array = getInputDataFromTableRow('.contentTable tbody');
			$.post('/' + administratorSitesFolder + '/library/capsule/admin/admin.ajax.php', {
				id: array,
				incl: include,
				control: 'admin/updateContentGlobal'
			}, function(data) {
				notificationCenter(data);
			});
		}

		function lowerString(string) {
			return (string + '').toLowerCase();
		}

		function copyToClipboard() {
			alert('s');
		}
	});
});
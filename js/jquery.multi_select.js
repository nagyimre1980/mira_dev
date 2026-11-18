// jquery.multi-select.js
// by mySociety
// https://github.com/mysociety/jquery-multi-select

;(function($) {

  "use strict";

  //var list_focus=0;
  var list_focus=-1;
  var pluginName = "multiSelect",
    defaults = {
      'containerHTML': '<div class="multi-select-container">',
      'menuHTML': '<div class="multi-select-menu">',
      'buttonHTML': '<span class="multi-select-button">',
      'menuItemsHTML': '<div class="multi-select-menuitems">',
      'menuItemHTML': '<label class="multi-select-menuitem">',
      'presetsHTML': '<div class="multi-select-presets">',
      'modalHTML': undefined,
      'menuItemTitleClass': 'multi-select-menuitem--titled',
      'activeClass': 'multi-select-container--open',
      'noneText': '-- Select --',
      'allText': undefined,
      'presets': undefined,
      'positionedMenuClass': 'multi-select-container--positioned',
      'positionMenuWithin': undefined,
      'viewportBottomGutter': 20,
      'menuMinHeight': 200,
	  'searchinp':false
    };

  /**
   * @constructor
   */
  
  function MultiSelect(element, options) {
    this.element = element;
    this.$element = $(element);
    this.settings = $.extend( {}, defaults, options );
    this._defaults = defaults;
    this._name = pluginName;
    this.init();
  }

  function arraysAreEqual(array1, array2) {
    if ( array1.length != array2.length ){
      return false;
    }

    array1.sort();
    array2.sort();

    for ( var i = 0; i < array1.length; i++ ){
      if ( array1[i] !== array2[i] ){
        return false;
      }
    }

    return true;
  }

  $.extend(MultiSelect.prototype, {

    init: function() {
      this.checkSuitableInput();
      this.findLabels();
      this.constructContainer();
      this.constructButton();
      this.constructMenu();
      this.constructModal();

      this.setUpBodyClickListener();
      this.setUpLabelsClickListener();

      this.hideOriginalElement();
	  
	 
    },

    checkSuitableInput: function(text) {
	  if ( this.$element.is('select[multiple]') === false ) {
        throw new Error('$.multiSelect only works on <select multiple> elements');
      }
    },

    findLabels: function() {
      this.$labels = $('label[for="' + this.$element.attr('id') + '"]');
    },

    constructContainer: function() {
      //console.log(this.$element.attr('id'));
	  this.$container = $(this.settings['containerHTML']);
	  //emre DIV-nek is legyen ID értéke
	  this.$container.attr('id',this.$element.attr('id')+"_contdiv");
	  
	  
      this.$element.data('multi-select-container', this.$container);
      this.$container.insertAfter(this.$element);
    },

    constructButton: function() {
      var _this = this;
      this.$button = $(this.settings['buttonHTML']);
      this.$button.attr({
        'role': 'button',
        'aria-haspopup': 'true',
        'tabindex': 0,
        'aria-label': this.$labels.eq(0).text()
      })
      .on('keydown.multiselect', function(e) {
        var key = e.which;
        var returnKey = 13;
        var escapeKey = 27;
        var spaceKey = 32;
        var downArrow = 40;
        if ((key === returnKey) || (key === spaceKey)) {
          e.preventDefault();
          //_this.$button.click();
          //emre
		  _this.$button.trigger('click');
        } else if (key === downArrow) {
          e.preventDefault();
          _this.menuShow();
          var group = _this.$presets || _this.$menuItems;
		  //group.children(":first").trigger("focus");
		  group.children().first().trigger("focus");//emre
        } else if (key === escapeKey) {
          _this.menuHide();
        }
      }).on('click.multiselect', function(e) {
        _this.menuToggle();
      }).on('blur.multiselect', this.checkBlur.bind(this))
      .appendTo(this.$container);
      this.$element.on('change.multiselect', function() {
        _this.updateButtonContents();
      });

      this.updateButtonContents();
    },

    updateButtonContents: function() {
      var _this = this;
      var options = [];
      var selected = [];


      this.$element.find('option').each(function() {
        var text = /** @type string */ ($(this).text());
		
        options.push(text);
        if ($(this).is(':selected')) {
          //selected.push( $.trim(text) );
          selected.push( text.trim() );//emre
        }
      });

      this.$button.empty();

      if (selected.length == 0) {
        this.$button.text( this.settings['noneText'] );
		this.$button.removeAttr("title");//emre
      } else if ( (selected.length === options.length) && this.settings['allText']) {
        this.$button.text( this.settings['allText'] );
      } else {
        this.$button.text( selected.join(', ') );
		this.$button.attr("title",selected.join(', '));//emre
      }
    },

    constructMenu: function() {
      var _this = this;
		var id_foe=this.$element.attr('id');
		
      this.$menu = $(this.settings['menuHTML']);
      this.$menu.attr({
        'role': 'menu'
      }).on('keydown.multiselect', function(e){
		  var key = e.which;
		
		if(key==13){//enter
		 $("#"+e.target.id).trigger('click');
		}
		  //Ha a list_focus 1, akkor a keresőre kell ugratni
		  if((list_focus==0 && key==38) || ( key==38 && $("#"+e.target.id+"_label").attr('sorszam')=='0' ) ){
			  $("#"+id_foe+"_searchinp").trigger('focus');
			  e.preventDefault();
			  return false;
		  }
      }).on('keydown.multiselect', function(e){
        var key = e.which;
        var escapeKey = 27;
        if (key === escapeKey) {
          _this.menuHide();
          _this.$button.trigger("focus");//emre
        }else if(key == '38'){//FEL
			_this.emre_lep_fel(id_foe);
				//csak keydown esetén kell
				e.preventDefault();
			  return false;
        }else if(key == '40'){//LE
		 	_this.emre_lep_le(id_foe);
				
				//csak keydown esetén kell
				e.preventDefault();
			  return false;
		}else{
			if(key !==undefined){
			 //Ami nincs bepipálva az legyen kuka
			 //$(".multi-select-menuitem[be=0]").css("background-color",'').css('text-decoration','').css("color",'#000');
			 
			 //keyup esetén kell
			 ////$(".multi-select-menuitem[be=0]").css("background-color",'').css('text-decoration','');
			 
			 //focus visszaáll az elejére
			 list_focus=-1;
			}
		}
		
      })
      .appendTo(this.$container);

      this.constructMenuItems();

      if ( this.settings['presets'] ) {
        this.constructPresets();
      }
    },

    emre_lep_fel: function(id) {//focus induláskor FEL
     //$(".multi-select-menuitem[for="+id+"_"+list_focus+id+"]").css("background-color",'').css("color",'#000');
	 //list_focus--;
	 //$(".multi-select-menuitem[for="+id+"_"+list_focus+id+"]").css("background-color",'#5897fb').css("color",'#000').trigger('focus');
	
	if(!$("#"+id+"_"+list_focus+id).prop('checked')){
	 //$("#"+id+"_"+list_focus+id+"_label").css("background-color",'').css('text-decoration','').css("color",'#000');
	 $("#"+id+"_"+list_focus+id+"_label").css("background-color",'').css("color",'').css('text-decoration','');
	}else{
		$("#"+id+"_"+list_focus+id+"_label").css('text-decoration','');
	}
	
	list_focus--;
	while( $("#"+id+"_"+list_focus+id+"_label").length && $("#"+id+"_"+list_focus+id+"_label").css('display')!='block' ){
	 list_focus--;
	}
	
	if(!$("#"+id+"_"+list_focus+id).prop('checked')){
	 //$("#"+id+"_"+list_focus+id+"_label").css("background-color",'#5897fb').css('text-decoration','underline').css("color",'#000').trigger('focus');
	 $("#"+id+"_"+list_focus+id+"_label").css("background-color",'#5897fb').css("color",'#fff').css('text-decoration','underline').trigger('focus');
	}else{
		$("#"+id+"_"+list_focus+id+"_label").css('text-decoration','underline').trigger('focus');
	}
	
	},
	
	emre_lep_le: function(id) {//focus induláskor LE
	//$(".multi-select-menuitem[for="+id+"_"+list_focus+id+"]").css("background-color",'');
	//$(".multi-select-menuitem[for="+id+"_"+list_focus+id+"]").css("background-color",'#5897fb').trigger('focus');
	//console.log(list_focus);
	
	if(!$("#"+id+"_"+list_focus+id).prop('checked')){
	 //$("#"+id+"_"+list_focus+id+"_label").css("background-color",'').css('text-decoration','').css("color",'#000');
	 $("#"+id+"_"+list_focus+id+"_label").css("background-color",'').css("color",'').css('text-decoration','');
	}else{
		$("#"+id+"_"+list_focus+id+"_label").css('text-decoration','');
	}
	
	list_focus++;
	
	while( $("#"+id+"_"+list_focus+id+"_label").length && $("#"+id+"_"+list_focus+id+"_label").css('display')!='block' ){
	 list_focus++;
	}
	
	if(!$("#"+id+"_"+list_focus+id).prop('checked')){
	 //$("#"+id+"_"+list_focus+id+"_label").css("background-color",'#5897fb').css('text-decoration','underline').css("color",'#000').trigger('focus');
	 $("#"+id+"_"+list_focus+id+"_label").css("background-color",'#5897fb').css("color",'#fff').css('text-decoration','underline').trigger('focus');
	}else{//De a focus akkor is kell!
		$("#"+id+"_"+list_focus+id+"_label").css('text-decoration','underline').trigger('focus');
	}
	
	 
	},
	
    emre_keress_bepipalaskor: function(id,label_id) {//focus induláskor
     //$(".multi-select-menuitem[be=0]").css("background-color",'').css("color",'#000');
     
	 $(".multi-select-menuitem[be=0]").css("background-color",'');
     $(".multi-select-menuitem").css('text-decoration','');
	 
	 if($("#"+label_id).prop('checked')){
	  //$("#"+label_id+"_label").css("background-color",'blue').css('text-decoration','underline').css("color",'#fff').attr('be','1');
	  $("#"+label_id+"_label").css("background-color",'#ddd').css("color",'#000').css('text-decoration','underline').attr('be','1');
	 }else{
	  $("#"+label_id+"_label").css("background-color",'#5897fb').css("color",'#fff').attr('be','0');
	  //$("#"+label_id+"_label").css("background-color",'').css("color",'').attr('be','0');
	 }
	 
	 list_focus=$("#"+label_id+"_label").attr('option_index');
	//console.log(label_id);
	},
	
	emre_keress_kilepeskor: function() {//focus induláskor
	 $(".multi_select_search").val("").trigger("keyup");
	},
	
    emre_keress_focusindulaskor: function(id) {//focus induláskor
	var _this_id=$("#"+id+'_searchinp');
	 if(_this_id.length){//De csak induláskor!!!
		_this_id.trigger("focus"); 
		//$(".multi_select_search").val("").trigger("keyup");
	 }
	 
	},
	
	
	matchStart_multiselect: function (params, data) {  
		//Ha van * karakter, akkor csonkolt
		if(params=="*"){
			 return data;
		}else if(params.indexOf("*")!=-1){
			//ker=params.term.slice(1);
			//console.log(ker);
			//console.log(data.text.toUpperCase().indexOf(params.term.toUpperCase()));
		 if (data.toUpperCase().indexOf(params.slice(1).toUpperCase())!=-1) {
			return data;
		}else{
			return null;
		}
		}else{//Különben csak az elején keresünk
		params = params || '';
		if (data.toUpperCase().indexOf(params.toUpperCase()) == 0) {
			return data;
		}else{
			return null;
		}
		}
		//return data;
	},

    emre_keress: function(id) {//keresés event
	 var _thism = this;
	 var _this_search=$("#"+id+'_searchinp');
	 if(_this_search.length){
		_this_search.on("keyup",function(){
		
		var keres_val=_this_search.val();
		if(keres_val!=''){
		var emre_keress_vant=0;
		var emre_keress_szam=0;
		$('#'+id+'_contdiv .multi-select-menuitem').each(function(){
			 var _this=$(this);
			 
			 //if(_this.text().trim()!="Január"){
			 if(!_thism.matchStart_multiselect(keres_val,_this.text().trim())){
			  _this.css("display","none").removeAttr('sorszam');
			 }else{
			  _this.css("display","block").attr('sorszam',emre_keress_szam);
			  emre_keress_vant=1;
			  emre_keress_szam++;
			 }
		});
		
		
		if(emre_keress_vant==0){
		 $('#'+id+'_searchnincs').css("display","block");
		}else{
		 $('#'+id+'_searchnincs').css("display","none");
		 //És ami elrejtődött azt ki is kell kapcsolni
		}
		
		}else{//Ekkor az összest meg kell mutatni>
			$('#'+id+'_contdiv .multi-select-menuitem').each(function(){
				$(this).css("display","block");
			});
			$('#'+id+'_searchnincs').css("display","none");
		}

		}).on("focus",function(){
			$(".multi-select-menuitem[be=0]").css("background-color",'').css("color",'#000').css('text-decoration','');
			list_focus=0;
		});
		
	 }
	},
	
    constructMenuItems: function() {
      var _this = this;

      this.$menuItems = $(this.settings['menuItemsHTML']);
	  
	  //emre - eleje
	  var id_foe=this.$element.attr('id');
	  if(this.settings['searchinp']){
	   this.$menu.append('<input id="'+id_foe+'_searchinp" class="multi_select_search" style="color:#000;padding-right:22px" maxlength="100" autocomplete="off" type="text">');
	   this.$menu.append('<span id="'+id_foe+'_searchnincs" class="multi_select_search_nincs">Nincs találat</span>');
	  }
	  //emre - vége

	  this.emre_keress(id_foe);
	  
	  
	  this.$menu.append(this.$menuItems);
	  
      
      this.$element.on('change.multiselect', function(e, internal) {
        // Don't need to update the menu items if this
        // change event was fired by our tickbox handler.
        if(internal !== true){
          _this.updateMenuItems();
        }
		
      });

      this.updateMenuItems();
    },

    updateMenuItems: function() {
      var _this = this;
      this.$menuItems.empty();

      this.$element.children('optgroup,option').each(function(index, element) {
        var $item;
        if (element.nodeName === 'OPTION') {
          $item = _this.constructMenuItem($(element), index);
          _this.$menuItems.append($item);
        } else {
          _this.constructMenuItemsGroup($(element), index);
        }
      });
    },

    upDown: function(type, e) {
    var key = e.which;
    var upArrow = 38;
    var downArrow = 40;

    if (key === upArrow) {
      e.preventDefault();
      var prev = $(e.currentTarget).prev();
      if (prev.length) {
        prev.trigger("focus");//emre
      } else if (this.$presets && type === 'menuitem') {
        //this.$presets.children(':last').trigger("focus");//emre
		this.$presets.children().last().trigger("focus");//emre
      } else {
        this.$button.trigger("focus");//emre
      }
    } else if (key === downArrow) {
      e.preventDefault();
      var next = $(e.currentTarget).next();
      if (next.length || type === 'menuitem') {
        next.trigger("focus");//emre
      } else {
        //this.$menuItems.children(':first').trigger("focus");//emre
		this.$menuItems.children().first().trigger("focus");//emre
      }
    }
  },

    constructPresets: function() {
      var _this = this;
      this.$presets = $(this.settings['presetsHTML']);
      this.$menu.prepend(this.$presets);

      $.each(this.settings['presets'], function(i, preset){
        var unique_id = _this.$element.attr('name') + '_preset_' + i;
        var $item = $(_this.settings['menuItemHTML'])
          .attr({
            'for': unique_id,
            'role': 'menuitem'
          })
          .text(' ' + preset.name)
          .on('keydown.multiselect', _this.upDown.bind(_this, 'preset'))
          .appendTo(_this.$presets);

        var $input = $('<input>')
          .attr({
            'type': 'radio',
            'name': _this.$element.attr('name') + '_presets',
            'id': unique_id
          })
          .prependTo($item);

        if (preset.all) {
          preset.options = [];
          _this.$element.find('option').each(function() {
            var val = $(this).val();
            preset.options.push(val);
          });
        }

        $input.on('change.multiselect', function(){
          _this.$element.val(preset.options);
          _this.$element.trigger('change');
        }).on('blur.multiselect', _this.checkBlur.bind(_this));
      });

      this.$element.on('change.multiselect', function() {
        _this.updatePresets();
      });

      this.updatePresets();
    },

    updatePresets: function() {
      var _this = this;

      $.each(this.settings['presets'], function(i, preset){
        var unique_id = _this.$element.attr('name') + '_preset_' + i;
        var $input = _this.$presets.find('#' + unique_id);

        if ( arraysAreEqual(preset.options || [], _this.$element.val() || []) ){
          $input.prop('checked', true);
        } else {
          $input.prop('checked', false);
        }
      });
    },

    constructMenuItemsGroup: function($optgroup, optgroup_index) {
      var _this = this;

      $optgroup.children('option').each(function(option_index, option) {
        var $item = _this.constructMenuItem($(option), optgroup_index + '_' + option_index);
        var cls = _this.settings['menuItemTitleClass'];
        if (option_index !== 0) {
          cls += 'sr';
        }
        $item.addClass(cls).attr('data-group-title', $optgroup.attr('label'));
        _this.$menuItems.append($item);
      });
    },

    constructMenuItem: function($option, option_index) {
      
	  //emre
	  var _this_fo=this;
	  
	  //var unique_id = this.$element.attr('name') + '_' + option_index;
	  //emre
	  var unique_id = this.$element.attr('name') + '_' + option_index+_this_fo.$element.attr('id');
	  	  
      var $item = $(this.settings['menuItemHTML'])
        .attr({
          'title': $option.attr('title'),//emre legyen title, ha nincs nincs
          'for': unique_id,
          'option_index': option_index,
		  'be': 0,
          'id': unique_id+"_label",
          'role': 'menuitem'
        })
        .on('keydown.multiselect', this.upDown.bind(this, 'menuitem'))
		.on('mouseover.multiselect',function(){
			$(".multi-select-menuitem[be=0]").css("background-color",'').css('color','');
		})
        .text(' ' + $option.text());

//emre - eleje
var only_radio=$option.attr("only_radio");
var only_radio_delete_fo=$option.attr("only_radio_delete_fo");

if(only_radio!==undefined && only_radio!=""){
      var $input = $('<input>')
        .attr({
          'type': 'checkbox',
          //'type': 'radio',
          'id': unique_id,
          'name': only_radio,
          'class': only_radio,
          'option_id': $option.attr("id"),
          'value': $option.val()
        })
        .prependTo($item);
}else if(only_radio_delete_fo!==undefined && only_radio_delete_fo!=""){
	     var only_radio_foid=_this_fo.$element.attr('id');
		 var $input = $('<input>')
        .attr({
          'type': 'checkbox',
          //'type': 'radio',
          'id': unique_id,
		  'class':only_radio_foid+'only_radio_delete_fo',
          'only_radio_delete_fo': only_radio_delete_fo,
          'option_id': $option.attr("id"),
          'value': $option.val()
        })
        .prependTo($item);
}else{
		//Csak az else ág volt bent simán
      var $input = $('<input>')
        .attr({
          'type': 'checkbox',
          'id': unique_id,
          'value': $option.val()
        })
        .prependTo($item);//emre
}//emre - vége

      if ( $option.is(':disabled') ) {
        $input.prop('disabled',true);
      }
      if ( $option.is(':selected') ) {
        $input.prop('checked', 'checked');
		//$("#"+$input.attr('id')+"_label").attr('be','1');
		//$item.css("background-color",'blue').css("color",'#fff').attr('be','1');
		$item.css("background-color",'#ddd').css("color",'#000').attr('be','1');
      }

      //$input.on('change.multiselect', function() {
      //emre
	  ////dupla keresés ellen
	  $input.on('change.multiselect', function(e,dupla_fut) {
      

		if (!dupla_fut && $(this).prop('checked')) {
          $option.prop('selected', true);
		  
		  //emre - eleje
		  var only_radio_mostid=this.id;
		  var only_radio_name=$(this).attr("name");
		  if(only_radio_name!==undefined){
			  $("."+only_radio_name).each(function() {
				var _this_emre_on=$(this);
				if(this.id!=only_radio_mostid && _this_emre_on.prop("checked")){
					//$(this).prop("checked",false).trigger('change', [true]);
					//emre dupla keresés
					_this_emre_on.prop("checked",false).trigger('change', [true]);
				}
				});
		  }
		  
		  //emre - vége
		  
		  //emre all összes - eleje
		  var only_radio_delete_fo_most=$(this).attr("only_radio_delete_fo");
		  if(only_radio_delete_fo_most!==undefined){//Ekkor az valamit csinálni kell
			if(only_radio_delete_fo_most=='fo'){//ALL dolgokat ki kell pipálni.
				var only_radio_name_al=$("."+only_radio_foid+"only_radio_delete_fo");
				only_radio_name_al.each(function(){
				 	var _this_fo_all=$(this);
					if(_this_fo_all.attr("only_radio_delete_fo")=='al' && _this_fo_all.prop("checked")){
					 _this_fo_all.prop("checked",false).trigger('change', [true]);
					 
					 //$("#"+this.id+"_label").css("background-color",'').css('text-decoration','').css("color",'#000');
					 $("#"+this.id+"_label").css("background-color",'').css('color','').css('text-decoration','');
					 
					}
				});
			}else if(only_radio_delete_fo_most=='al'){//fo ki kell pipálni.
				var only_radio_name_al=$("."+only_radio_foid+"only_radio_delete_fo");
				only_radio_name_al.each(function(){
				 	var _this_fo_all=$(this);
					if(_this_fo_all.attr("only_radio_delete_fo")=='fo' &&  _this_fo_all.prop("checked") ){
					 _this_fo_all.prop("checked",false).trigger('change', [true]);
					 
					 //$("#"+this.id+"_label").css("background-color",'').css('text-decoration','').css("color",'#000');
					 $("#"+this.id+"_label").css("background-color",'').css('color','').css('text-decoration','');
					}
				});
			}
		  }
		  //emre all összes - vége
		  
        } else {
          $option.prop('selected', false);
		  var class_most=$(this).attr('class');
		  var vanbepipalt='0';
		  $("."+class_most+":checkbox").each(function(){
			if($(this).attr("only_radio_delete_fo")=='al'){
			 if($(this).prop('checked'))vanbepipalt='1';
			}
		  });
		  if(vanbepipalt=='0'){
			  //console.log('bepipálás');
			  $("."+class_most+":checkbox").each(function(){
					if($(this).attr("only_radio_delete_fo")=='fo'){
					 $(this).prop("checked",true);
					}
			  });
			  
		  }
        }
		
		//dupla keresés ellen
		
		if(!dupla_fut){
		 $option.trigger('keyup');

		setTimeout(function(){
		 _this_fo.emre_keress_bepipalaskor(_this_fo.$element.attr('id'),unique_id);
		},0);
		
		}
		
//emre Dialog albkban az átméretezés
setTimeout(function(){
 //_this_fo.menuHide();//Elég a show
 _this_fo.menuShow(); 
},100);


        // .prop() on its own doesn't generate a change event.
        // Other plugins might want to do stuff onChange.
        $option.trigger('change', [true]);
      }).on('blur.multiselect', this.checkBlur.bind(this));

	
      return $item;
    },

    constructModal: function() {
      var _this = this;

      if (this.settings['modalHTML']) {
        this.$modal = $(this.settings['modalHTML']);
        this.$modal.on('click.multiselect', function(){
          _this.menuHide();
        })
        this.$modal.insertBefore(this.$menu);
      }
    },

    setUpBodyClickListener: function() {
      var _this = this;

      // Hide the $menu when you click outside of it.
      //$('html').on('click.multiselect', function(){
      //emre. Így lehet  szőkíteni, mert induláskor rögtön be akarta zárni
	  //$('body:not(".multi-select-button")').on('click.multiselect', function(){
	  //$('body:not("#'+this.$element.attr('id')+'_contdiv'+',#'+this.id+'")').on('click.multiselect', function(){
	  //$('*:not("#riport_tervteny_sel_ho1_contdiv")').on('click.multiselect', function(){
	  $('html').on('click.multiselect', function(){
		_this.menuHide();
		//_this.emre_keress_kilepeskor();
      });
	  
	  /*
		$('html').on('keyup.multiselect', function(e){//FIONA esetén vagy dialog ablakban nem biztos hogy jó!
			if(e.which==27){//esc
			 //_this.menuHide();
			 console.log('alma');
			 _this.emre_keress_kilepeskor();
			}
		});
		*/
		
      // Stop click events from inside the $button or $menu from
      // bubbling up to the body and closing the menu!
      this.$container.on('click.multiselect', function(e){
        e.stopPropagation();
      });
    },

    setUpLabelsClickListener: function() {
      var _this = this;
      this.$labels.on('click.multiselect', function(e) {
        e.preventDefault();
        e.stopPropagation();
        _this.menuToggle();
      });
    },

    hideOriginalElement: function() {
      this.$element.hide();
      this.$labels.removeAttr('for');
    },

    menuShow: function() {
      //console.log('indul');
	  //emre
	  
	  //Keresésnél átméretézéskor jó legyen, de menű nyitáskor ez vissza kell csinálni
	  $('.div_kereshez_ker').css('overflow-x','visible');
	  $('html').trigger('click.multiselect'); // Close any other open menus
      this.$container.addClass(this.settings['activeClass']);

      if ( this.settings['positionMenuWithin'] && this.settings['positionMenuWithin'] instanceof $ ) {
        var menuLeftEdge = this.$menu.offset().left + this.$menu.outerWidth();
        var withinLeftEdge = this.settings['positionMenuWithin'].offset().left +
          this.settings['positionMenuWithin'].outerWidth();

        if ( menuLeftEdge > withinLeftEdge ) {
          this.$menu.css( 'width', (withinLeftEdge - this.$menu.offset().left) );
          this.$container.addClass(this.settings['positionedMenuClass']);
        }
      }

      var menuBottom = this.$menu.offset().top + this.$menu.outerHeight();
      //var viewportBottom = $(window).scrollTop() + $(window).height();
      //if ( menuBottom > viewportBottom - this.settings['viewportBottomGutter'] ) {
		//emre
      var menuBottom = this.$menu.offset().top + this.$menu.outerHeight();
      var viewportBottom = $(window).scrollTop() + $(window).height();
	  
	        //emre
	  if($('#dialog_egyeni_close').dialog('isOpen')){
		//var viewportBottom_dialog=$("#dialog_egyeni_close").height();
		var viewportBottom = $("#dialog_egyeni_close").height()+80;
	  }
		
	  
	  
      if ( menuBottom > viewportBottom - this.settings['viewportBottomGutter'] ) {
        this.$menu.css({
          'maxHeight': Math.max(
            viewportBottom - this.settings['viewportBottomGutter'] - this.$menu.offset().top,
            this.settings['menuMinHeight']
          ),//emre auto-ra scroll-ról
          'overflow': 'auto'
        });
      } else {
        this.$menu.css({
          'maxHeight': '',
          'overflow': ''
        });
      }
	  
	  //emre
	  //Ha van keresés, akkor legyenrajta a focus
	  //this.emre_keress_focusindulaskor(this.$element.attr('id'));
	  
    },


    menuHide: function() {
	  //console.log('bezár');
	  //emre
	  //Keresésnél átméretézéskor jó legyen, de menű nyitáskor ez vissza kell csinálni
	  $('.div_kereshez_ker').css('overflow-x','auto');
	  
	  //$(".multi_select_search").val("").trigger("keyup");
	  
	  this.$container.removeClass(this.settings['activeClass']);
      this.$container.removeClass(this.settings['positionedMenuClass']);
      this.$menu.css('width', 'auto');
    },

    menuToggle: function() {
      if ( this.$container.hasClass(this.settings['activeClass']) ) {
        this.menuHide();
      } else {
		
		this.emre_keress_kilepeskor();
		
		this.menuShow();
		
		//emre
		//Ha van keresés, akkor legyenrajta a focus
		this.emre_keress_focusindulaskor(this.$element.attr('id'));
		
      }
    },

    checkBlur: function(e) {
      if (e.relatedTarget && !$(e.relatedTarget).closest(this.$container).length) {
        //emre kikapcsoltam, mert dialog ablakban így a szövegre kattintva is eltűnik
		//this.menuHide();
      }
    }

  });

  $.fn[ pluginName ] = function(options) {
    return this.each(function() {
      if ( !$.data(this, "plugin_" + pluginName) ) {
		$.data(this, "plugin_" + pluginName,
          new MultiSelect(this, options) );
      }
    });
  };

})(jQuery);
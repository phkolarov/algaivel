/**
	*	jQuery plugin Money
	* -------------------
	* @release 04.12.2008
	* @version 2.0
	*
	*/
	
$.fn.money = function(options) {
	return this.each(function() {
		
	});
};

(function($) {
	$.fn.money = function(options) {
		
		var args = {
			mask  : '',
			value : ''
		};
		var options = $.extend(args, options); 
		
		return this.each(function() {
			//- BASIC VARIABLES
			//-----------------
			var field      =  this;        // jQuery обект на текущия елемент
			var isIE       =  false;
			var output     =  '';
			var fract      =  2
			var spacer     =  ',';
			var spaceSize  =  3
			var infinit    =  -1
			var mask       =  '~,###.##';
			var value      =  '0.00';

			$(field).attr('moneyMasked', 1);
			
			//- INITIAL VALIDATION
			if(field.tagName.toUpperCase()!='INPUT') 
			//if(field.tagName.toUpperCase()!='INPUT'||field.getAttribute('type').toUpperCase()!='TEXT') 
				return false;
			if(field.value != undefined && field.value != '')
				value = field.value;
			else {
				if(args.value != undefined && args.value != '')
					value = args.value;
			}
			if(args.mask != undefined && args.mask != '')
				mask = args.mask;
				
			//alert(value + ' --- ' + mask);
				
			//- CSS SETTINGS
			//--------------
			$(field).css('textAlign', 'right');
			
			//- променлива за Firefox
			/*
			var isIE = false;
			if(jQuery.browser.msie)
				isIE = true;
			else if(jQuery.browser.mozilla)
				isIE = false;
			*/
			__parseMASK(mask);
			__parseVALUE(value);
			
			
			//- EVENT HANDLING FUNCTIONS
			//--------------------------
			if(!$(field).attr('readonly')) {
				
				$(field).focus(function() {
					// Read field value and Set caret position after focus
					value=field.value;
					__parseVALUE(value);
					var start=output.length-fract-1;
					setTimeout(function() {
						__setCaret(start,start);
					}, 0);
				});
				
				$(field).blur(function() {
					// Fire change event (if there is a change)
					if(value!=field.value) {
						/*
						if(document.createEvent){
							var evObj=document.createEvent('HTMLEvents');
							evObj.initEvent('change', true, false);
							field.dispatchEvent(evObj);
						}else if(document.createEventObject){
							var evObj=document.createEventObject();
							field.fireEvent('onchange');
						}
						*/
						$(this).change();
					}
				});
				
				$(field).keydown(function(event) {
					if( $(field).attr('write') != undefined ) {
						if( !parseInt($(field).attr('write')) ) return false;
					}
					event = event || window.event;
					key = event.charCode || event.keyCode || event.which;	
					if(key==9)return true;   // TAB
					if(key==16)return true;  // SHIFT
					if(key==17)return true;  // CTRL
					if(key==18)return true;  // ALT
					if(key==37)return true;  // Arrow LEFT
					if(key==39)return true;  // Arrow RIGHT
					if(key==110||key==190) { // [.]
						var start=output.length-fract;
						__setCaret(start,start);
					}
					if((key>=48&&key<=57)||(key>=96&&key<=105)) { // Numbers [0-9] and "-"
						return true;
					}
					if(key==8) { // BACKSPACE
						var caret=__getCaret();
						if((caret.f-caret.s)>0) {
							var offset=output.length-caret.f;
							__removePack(caret);
							var n=output.length-offset;
							__setCaret(n,n);
						} else {
							var n=(caret.s-1);
							var offset=output.length-n-1;
							if(n>=0) {
								if(/\d/.test(output.charAt(n))){
									var fracture=__getPart(caret);
									if(!fracture){
										__removeChar(n);
										n=output.length-offset;
										if(n<0)n=0;
										__setCaret(n,n);
									} else {
										__replaceChar(n,'0');
										n=output.length-offset;
										__setCaret(n-1,n-1);
									}
								} else __setCaret(n,n);
							}
						}
						return false;
					}
					if(key==46) { // DELETE
						var caret=__getCaret();
						if((caret.f-caret.s)>0) {
							var offset=output.length-caret.f;
							__removePack(caret);
							var n=output.length-offset;
							__setCaret(n,n);
						} else {
							var n=caret.s;
							var offset=output.length-n;
							if(/\d/.test(output.charAt(n))){
								var fracture=__getPart(caret);
								if(!fracture){
									__removeChar(n);
									if(output.length==(fract+2)&&output.charAt(0)=='0') n++;
									__setCaret(n,n);
								} else {
									__replaceChar(n,'0');
									__setCaret(n+1,n+1);
								}
							} else {n++;__setCaret(n,n);}
						}
						return false;
					}
					if(key==27) { // ESCAPE
						__reset();
						return false;
					}
					return false;
				});
				
				$(field).keypress(function(event) {
					if(field.getAttribute('readonly')) return false;
					event = event || window.event;
					key = event.charCode || event.keyCode || event.which;	
					if(key==9)return true;   // TAB
					if(key==37)return true;  // Arrow LEFT
					if(key==39)return true;  // Arrow RIGHT
					if(key>=48&&key<=57) { // Numbers [0-9]
						var caret=__getCaret();
						if(caret.s==0&&caret.f==0&&key==48)return false;
						if(caret.f-caret.s>0) {
							var n=caret.f;
							var offset=output.length-n;
							__replacePack(caret,String.fromCharCode(key)); 
							n=output.length-offset;
							__setCaret(n,n);
						} else {
							var fracture=__getPart(caret);
							if(!fracture) {
								var intPart=field.value.split('.')[0].replace(/\D/g,'');
								if(infinit!=-1&&intPart.length>=infinit) return false;
								var offset=output.length-caret.s;
								__insertChar(caret.s,String.fromCharCode(key));
								var n=output.length-offset;
								__setCaret(n,n);
							} else {
								var offset = output.length-caret.s;
								__replaceChar(caret.s,String.fromCharCode(key));
								__setCaret(caret.s+1,caret.s+1);
							}
						}
					}
					return false;
				});
				
			}
			
			//---  FUNCTIONS  ----
			//--------------------
			/**
				* 
				*/
			function __parseMASK(mask) {
				// detect infinity
				var aPart=mask.split('.');
				if(/^\~/.test(mask)) {
					infinit=-1;
					mask=mask.replace(/^\~/,'');
				} else {
					var intPart='';
					for(var i=0; i<aPart[0].length; i++) {
						if(aPart[0].charAt(i)=='#') intPart += '#';
					}
					infinit=intPart.length;
				}
				// detect fracture part
				(aPart.length<2)?fract=2:(aPart[1].length==0)?fract=2:fract=aPart[1].length;
				// detect integer part
				spaceSize=0;
				if(aPart[0].length==0) {
					spaceSize=3;
					spacer=','
				} else {
					for(var i=(aPart[0].length-1);i>=0;i--) {
						if(aPart[0].charAt(i)=='#') spaceSize++;
						else {
							spacer=aPart[0].charAt(i);
							break;
						}
					}
				}
			}
			
			/**
				*
				*/
			function __parseVALUE(value) {
				output='';
				value=(value+'').replace(/[^\.|\d]/g, '');
				if(value==''||value=='0') {
					__reset();
				} else {
					var aPart = value.split('.');
					if(aPart.length==1) {
						for(var i=0; i<fract; i++) output='0'+output;
						output='.'+output;
						var cnt=0;
						for(var j=(aPart[0].length-1);j>=0;j--) {
							if(infinit>-1&&(j+1)>infinit) {
								__reset();
								//throw 'The integer part is limited to ['+infinit+'] digits !';
								alert('The integer part is limited to ['+infinit+'] digits !');
								return false;
							}
							cnt++;
							if(!(cnt%(spaceSize+1))){ 
								output=spacer+output;
								cnt=1;
							}
							output=aPart[0].charAt(j)+output;
						}
					} else if(aPart.length==2) {
						
						for(var i=(fract-1);i>=0;i--) {
							if(aPart[1].charAt(i)=='') output='0'+output;
							else output=aPart[1].charAt(i)+output;
						}
						output='.'+output;
						var cnt=0;
						if(aPart[0].length>1) {// trim value [0] from the beginning
							aPart[0]=aPart[0].replace(/^0+/,'');
						}
						if(aPart[0].length==0) {
							output='0'+output; 
						} else {
							for(var j=(aPart[0].length-1);j>=0;j--) {
								if(infinit>-1&&(j+1)>infinit) {
									__reset();
									throw 'The integer part is limited to ['+infinit+'] digits !';
								}
								cnt++;
								if(!(cnt%(spaceSize+1))){
									output=spacer+output;
									cnt=1;
								}
								output=aPart[0].charAt(j)+output;
							}
						}
					}
				}
				__draw();
			}
			
			/**
				*
				*/
			function __insertChar(n, arg) {
				// Insert character into String
				var sL=output.substr(0,n);
				var sR=output.substr(n,output.length);
				output=sL+arg+sR;
				__parseVALUE(output);
			}
			/**
				*
				*/
			function __removeChar(n) {
				// Remove character from Srting
				var sL=output.substr(0,n);
				var sR=output.substr((n+1),(output.length-1));
				output=sL+sR;
				__parseVALUE(output);
			}
			/**
				*
				*/
			function __replaceChar(n, arg) {
				// Replace character into Srting
				var sL=output.substr(0,n);
				var sR=output.substr((n+1),(output.length-1));
				output=sL+arg+sR;
				__parseVALUE(output);
			}
			
			/**
				*
				*/
			function __removePack(caret) {
				// Remove several from Srting
				var sL=output.substr(0,caret.s);
				var sM=output.substr(caret.s,caret.f-caret.s);
				var sR=output.substr(caret.f,output.length-1);
				var res='';
				var fracture=__getPart(caret);
				if(!fracture) {
					var aParts=sM.split('.');
					if(aParts.length>1) {
						res+='.';
						for(var i=0; i<aParts[1].length; i++) res+='0';
					}else{res='';}
				} else {
					for(var i=0;i<sM.length;i++) res+='0';
				}
				output=sL+res+sR;
				__parseVALUE(output);
				__setCaret(0,0)
			}
			
			/**
				*
				*/
			function __replacePack(caret,arg) {
				
				// Insert several into Srting
				var sL=output.substr(0,caret.s);
				var sM=output.substr(caret.s,caret.f-caret.s);
				var sR=output.substr(caret.f,output.length-1);
				var res='';
				var fracture=__getPart(caret);
				if(!fracture) {
					res+=arg;
					var aParts=sM.split('.');
					if(aParts.length>1) {
						res+='.';
						for(var i=0;i<aParts[1].length;i++) res+='0';
					}else{res=arg;}
				} else {
					for(var i=0;i<sM.length;i++) {
						(i==0)?res+=arg:res+='0';
					}
				}
				output=sL+res+sR;
				__parseVALUE(output);
			}
			
			/**
				*
				*/
			function __getPart(caret) {
				if(caret.s>=(output.length-fract))return true;
				else return false;
			}
			
			/**
				*
				*/
			function __reset() {
				output='';
				for(var i=0;i<fract;i++) output+='0';
				output='.'+output;
				output='0'+output;
				__draw();
			}
			
			/**
				*
				*/
			function __draw() {
				field.value=output;
			}
			
			/**
				*
				*/
			function __setCaret(start,end,bla) {
				// Set caret position
				var o=field;
				if (document.selection) { 
					field.focus();
					var sel=document.selection.createRange();
					sel.moveEnd ('character',-field.value.length);
					sel.moveStart ('character',start);
					sel.moveEnd ('character',(end-start));
					sel.select();
				}
				else {
					field.selectionStart=start;
					field.selectionEnd=end;
				}
			}
			
			/**
				*
				*/
			function __getCaret() {
				// Get caret position
				var res={s:0,f:0};
				if (field.createTextRange) {
					var r=document.selection.createRange().duplicate();
					r.moveEnd('character',field.value.length);
					if(r.text==''){res.s=field.value.length;}
					else{res.s=field.value.lastIndexOf(r.text);}
					
					var r=document.selection.createRange().duplicate();
					r.moveStart('character',-field.value.length);
					res.f=r.text.length;
				} else {
					res.s=field.selectionStart;
					res.f=field.selectionEnd;
				}
				return res;
			}
		});
	};
})(jQuery);



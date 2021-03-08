$(function(){
	$.ajaxSetup({url: PF.obj.config.json_api, cache: false, dataType: "json"});
	
	/**
	 * WINDOW LISTENERS
	 * -------------------------------------------------------------------------------------------------
	 */
	$(window).bind("beforeunload",function(){
		if($(PF.obj.modal.selectors.root).is(":visible") && PF.fn.form_modal_has_changed()) {
			return PF.fn._s("All the changes that you have made will be lost if you continue.");
		}
	});
	
	$(window).bind("hashchange", function(){
		// Call edit modal on #edit
		if(window.location.hash=="#edit" && !$(PF.obj.modal.selectors.root).exists()) $("[data-modal=edit]").first().click();
	});
	
	// Blind the tipTips on load
	PF.fn.bindtipTip();
	
	// Fluid width on resize
	$(window).on("resize", function(){
		if($("body").is_fluid()){
			PF.fn.list_fluid_width();
			if(PF.obj.listing.columns_number !== PF.obj.listing.content_listing_ratio){
				PF.fn.listing.columnizer(true);
			}
			$(PF.obj.listing.selectors.list_item).show();
		}
		//PF.fn.fullscreen.size();
	});
	
	// Close the opened pop-boxes on HTML click
	$(document).on("click", "body, html", function(e){
		PF.fn.close_pops();
	});
	
		
	/**
	 * SMALL HELPERS AND THINGS
	 * -------------------------------------------------------------------------------------------------
	 */
	
	// Attemp to replace .svg with .png for browsers that doesn't support it
	if($("html").hasClass("no-svg")){
		$("img.replace-svg").replace_svg();
	}
	
	// Keydown numeric input (prevents non numeric keys)
	$(document).on("keydown", ".numeric-input", function(e){
		e.keydown_numeric();
	});
	
	// The handly data-scrollto. IT will scroll the elements to the target
	$(document).on("click", "[data-scrollto]", function(e) {
		var target = $(this).data("scrollto"),
			$target = $(!target.match(/^\#|\./) ? "#"+target : target);
		
		if($target.exists()) {
			PF.fn.scroll($target);
		} else {
			console.log("PF scrollto error: target doesn't exists", $target);
		}
	});
	
	// The handly data-trigger. It will trigger click for elements with data-trigger
	$(document).on("click", "[data-trigger]", function(e) {
		var trigger = $(this).data("trigger"),
			$target = $(!trigger.match(/^\#|\./) ? "#"+trigger : trigger);
			
		if($target.exists()) {
			e.stopPropagation();
			e.preventDefault();
			
			if(!$target.closest(PF.obj.modal.selectors.root).length) {
				PF.fn.modal.close();
			}
			
			$target.click();
		} else {
			console.log("PF trigger error: target doesn't exists", $target);
		}
	});
	
	
	// Clear form like magic
	$(document).on("click", ".clear-form", function(){
		$(this).closest("form")[0].reset();
	});
	
	$(document).on("submit", "form[data-action=validate]", function() {
		
		var type = $(this).data("type"),
			errors = false,
			$validate = $(this).find("[required], [data-validate]");
		
		$validate.each(function() {
			
			var input_type = $(this).attr("type"),
				pattern = $(this).attr("pattern"),
				errorFn = function(el) {
					$(el).highlight();
					errors = true;
				};
			
			if($(this).is("[required]") && $(this).val() == "") {
				if($(this).is(":hidden")) {
					var $hidden_target = $($($(this).data("highlight")).exists() ? $(this).data("highlight") : "#" + $(this).data("highlight"));
					$($hidden_target).highlight();
				}
				errorFn(this);
			}
			
			if(typeof pattern == "undefined" && /mail|url/.test(input_type) == false) {
				return true;
			}
			
			if(pattern) {
				pattern = new RegExp(pattern);
				if(!pattern.test($(this).val())) {
					errorFn(this);
				}
			}
			
			if(input_type == "email" && !$(this).val().isEmail()) {
				errorFn(this);
			}
			
		});

		if(errors) {
			PF.fn.growl.expirable(PF.fn._s("Check the errors in the form to continue."));
			return false;
		}
	});
	
	// Co-combo breaker
	$(document).on("change", "select[data-combo]", function(){
		if($("#"+$(this).data("combo")).exists()){
			$(".switch-combo", $("#"+$(this).data("combo"))).hide();
		}

		var $combo_container = $("#" + $(this).closest("select").data("combo")),
			$combo_target = $("[data-combo-value=" + $("option:selected", this).attr("value") + "]", $combo_container);
		
		if($combo_target.exists()){
			$combo_target.show();
			$combo_target.find("input").first().focus();
		}
	});
	
	// Input events
	$(document).on("change", ":input", function(e){
		PF.fn.growl.close();
	});
	$(document).on("keyup", ":input", function(e){
		$(".input-warning", $(this).closest(".input-label")).html("");
	});
	$(document).on("blur", ":input", function(){
		var this_val = $.trim($(this).prop("value"));
		$(this).prop("value", this_val);
	});
	
	// Select all on an input type
	$(document).on("click", ":input[data-focus=select-all]", function() {
		 this.select();
	})
	
	// Input password strength
	$(document).on("keyup change blur", ":input[type=password]", function(){
		var password = testPassword($(this).val()),
			$parent = $(this).closest("div");
		
		if($(this).val() == "") {
			password.percent = 0;
			password.verdict = "";
		}
		
		$("[data-content=password-meter-bar]", $parent).width(password.percent);
		$("[data-text=password-meter-message]", $parent).removeClass("red-warning").text(password.verdict !== "" ? PF.fn._s(password.verdict) : "");
		
	});
	
	// Popup links
	$(document).on("click", "[rel=popup-link], .popup-link", function(e){
		e.preventDefault();
		var href;
		if(typeof $(this).attr("href") !== "undefined") {
			href = $(this).attr("href");
		} else {
			href = $(this).data("href");
		}
		if(typeof href == "undefined") {
			return;
		}
		PF.fn.popup({href: href});
	});
	
	/**
	 * FOWLLOW SCROLL
	 * -------------------------------------------------------------------------------------------------
	 */
	$(window).scroll(function(){
//		alert('125');
		PF.fn.follow_scroll();
	});
	
	
	/**
	 * MODAL
	 * -------------------------------------------------------------------------------------------------
	 */
	 
	// Call plain simple HTML modal
	$(document).on("click", "[data-modal=simple],[data-modal=html]", function(){
		var $target = $("[data-modal=" + $(this).data("target") + "], #"+$(this).data("target")).first();
		PF.fn.modal.call({template: $target.html(), buttons: false});
	});
	
	// Prevent modal submit form since we only use the form in the modal to trigger HTML5 validation
	$(document).on("submit", PF.obj.modal.selectors.root + " form", function(){
		if($(this).data("prevent") == "false") return true;
		return false;
	});
	
	// Form/editable/confirm modal
	$(document).on("click", "[data-modal=edit],[data-modal=form],[data-confirm]", function(){
		
		var $this = $(this),
			$target, submit_function, cancel_function, submit_done_msg;
		
		if($this.is("[data-confirm]")) {
			$target = $this;
			PF.obj.modal.type = "confirm";
		} else {
			
			$target = $("[data-modal=" + $this.data("target") + "], #"+$this.data("target")).first();
			
			if($target.length == 0) {
				$target = $("[data-modal=form-modal], #form-modal").first();
			}

			if($target.length == 0) {
				console.log("PF Error: Modal target doesn't exists.");
			}

			PF.obj.modal.type = $this.data("modal");
		}
		
		var args = $this.data("args");
		
		var submit_function = window[$target.data("submit-fn")],
			cancel_function = window[$target.data("cancel-fn")],
			submit_done_msg = $target.data("submit-done"),
			ajax = {
				url: $target.data("ajax-url"),
				deferred: window[$target.data("ajax-deferred")]
			};
		
		// Window functions failed? Maybe is an anonymous fn...
		if(typeof submit_function !== "function" && $target.data("submit-fn")) {
			var submit_fn_split = $target.data("submit-fn").split(".");
			submit_function = window;
			for(var i=0; i<submit_fn_split.length; i++) {
				submit_function = submit_function[submit_fn_split[i]];
			}
		}
		if(typeof cancel_function !== "function" && $target.data("cancel-fn")) {
			var cancel_fn_split = $target.data("cancel-fn").split(".");
			cancel_function = window;
			for(var i=0; i<cancel_fn_split.length; i++) {
				cancel_function = cancel_function[cancel_fn_split[i]];
			}
		}

		// deferred was not a window object? Maybe is an anonymous fn...
		if(typeof ajax.deferred !== "object" && $target.data("ajax-deferred")) {
			var deferred_obj_split = $target.data("ajax-deferred").split(".");
			ajax.deferred = window;
			for(var i=0; i<deferred_obj_split.length; i++) {
				ajax.deferred = ajax.deferred[deferred_obj_split[i]];
			}
		}
		
		// Confirm modal
		if($this.is("[data-confirm]")) {		
			PF.fn.modal.confirm({
				message: $this.data("confirm"),
				confirm: typeof submit_function == "function" ? submit_function(args) : "",
				cancel: typeof cancel_function == "function" ? cancel_function(args) : "",
				ajax: ajax
			});
		// Form/editable
		} else {
			
			var fn_before = window[$target.data("before-fn")];
			
			if(typeof fn_before !== "function" && $target.data("before-fn")) {
				var before_obj_split = $target.data("before-fn").split(".");
				fn_before = window;
				for(var i=0; i<before_obj_split.length; i++) {
					fn_before = fn_before[before_obj_split[i]];
				}
			}
			
			if(typeof fn_before == "function") {
				fn_before();
			}
			
			PF.fn.modal.call({
				template: $target.html(),
				button_submit: $(this).is("[data-modal=edit]") ? PF.fn._s("Save changes") : PF.fn._s("Submit"),
				confirm: function() {
					
					if(PF.fn.is_validity_supported()){
					}// aca
					
					if(typeof submit_function == "function") submit_fn = submit_function();
					if(typeof submit_fn !== "undefined" && submit_fn == false) {
						return false;
					}
					
					// Run the full function only when the form changes
					if(!PF.fn.form_modal_has_changed()){
						PF.fn.modal.close();
						return;
					}
					
					$(":input", PF.obj.modal.selectors.root).each(function(){
						$(this).val($.trim($(this).val()));
					});
					
					if($this.is("[data-modal=edit]")) {
						// Set the input values before cloning the html
						$target.html($(PF.obj.modal.selectors.body, $(PF.obj.modal.selectors.root).bindFormData()).html().replace(/rel=[\'"]tooltip[\'"]/g, 'rel="template-tooltip"'));
					}
					
					if(typeof ajax.url !== "undefined") {
						return true;
					} else {
						PF.fn.modal.close(
							function(){
								if(typeof submit_done_msg !== "undefined"){
									PF.fn.growl.expirable(submit_done_msg !== "" ? submit_done_msg : PF.fn._s("Changes saved successfully."))
								}
							}
						);
					}

					
				},
				cancel: function() {
					if(typeof cancel_fn == "function") cancel_fn = cancel_fn();
					if(typeof cancel_fn !== "undefined" && cancel_fn == false) {
						return false;
					}
					// nota: falta template aca
					if(PF.fn.form_modal_has_changed()) {
						if($(PF.obj.modal.selectors.changes_confirm).exists()) return;
						$(PF.obj.modal.selectors.box, PF.obj.modal.selectors.root).fadeOut("fast");
						$(PF.obj.modal.selectors.root).append('<div id="'+PF.obj.modal.selectors.changes_confirm.replace("#", "")+'"><div class="content-width"><h2>'+PF.fn._s("All the changes that you have made will be lost if you continue.")+'</h2><div class="'+ PF.obj.modal.selectors.btn_container.replace(".", "") +' margin-bottom-0"><button class="btn btn-input default" data-action="cancel">'+PF.fn._s("Go back to form")+'</button> <span class="btn-alt">'+PF.fn._s("or")+' <a data-action="submit">'+PF.fn._s("continue anyway")+'</a></span></div></div>');
						$(PF.obj.modal.selectors.changes_confirm).css("margin-top", -$(PF.obj.modal.selectors.changes_confirm).outerHeight(true)/2).hide().fadeIn();
					} else {
						PF.fn.modal.close();
						if(window.location.hash=="#edit") window.location.hash = "";
					}
				},
				callback: function(){},
				ajax: ajax
			})
		}
		
	});
	
	// Check user login modal -> Must be login to continue
	if(!PF.fn.is_user_logged()){
		$("[data-login-needed]:input, [data-user-logged=must]:input").each(function(){
			$(this).attr("readonly", true);
		});
	}
	// nota: update junkstr
	$(document).on("click focus", "[data-login-needed], [data-user-logged=must]", function(e) {
		if(!PF.fn.is_user_logged()){
			e.preventDefault();
			e.stopPropagation();
			if($(this).is(":input")) $(this).attr("readonly", true).blur();
			PF.fn.modal.call({type: "login"});
		}
	});
	
	// Modal form keydown listener
	$(document).on("keydown", PF.obj.modal.selectors.root + " input", function(e){ // nota: solia ser keyup
		var $this = $(e.target),
			key = e.charCode || e.keyCode;
		if(key !== 13){
			PF.fn.growl.close();
			return;
		}
		if(key==13 && $("[data-action=submit]", PF.obj.modal.selectors.root).exists() && !$this.is(".prevent-submit")){ // 13 == enter key
			$("[data-action=submit]", PF.obj.modal.selectors.root).click();
		}
	});
	
	
	// Trigger modal edit on hash #edit
	// It must be placed after the event listener
	if(window.location.hash && window.location.hash=="#edit"){
		$("[data-modal=edit]").first().click();
	}
	
	
	/**
	 * SEARCH INPUT
	 * -------------------------------------------------------------------------------------------------
	 */
	
	// Top-search feature
	$(document).on("click", "#top-bar-search", function(){
		$("#top-bar-search-input", ".top-bar").removeClass("hidden").show();
		$("#top-bar-search-input input", ".top-bar").focus();
		$("#top-bar-search", ".top-bar").hide();
	});
	
	// Search icon click -> focus input
	$(document).on("click", ".input-search .icon-search", function(e){
		$("input", e.currentTarget.offsetParent).focus();
	});
	
	// Clean search input
	$(document).on("click", ".input-search .icon-close, .input-search [data-action=clear-search]", function(e){
		var $input = $("input", e.currentTarget.offsetParent);
		
		if($input.val()==""){
			if($(this).closest("#top-bar-search-input").exists()){
				$("#top-bar-search-input", ".top-bar").hide();
				$("li#top-bar-search", ".top-bar").removeClass("opened").show();
			}
		} else {
			if(!$(this).closest("#top-bar-search-input").exists()){
				$(this).hide();
			}
			$input.val("").change();
		}
	});
	
	// Input search clear search toggle
	$(document).on("keyup change", "input.search", function(e){
		var $input = $(this),
			$div = $(this).closest(".input-search");
		
		if(!$(this).closest("#top-bar-search-input").exists()) {
			$(".icon-close, [data-action=clear-search]", $div)[$input.val() == "" ? "hide" : "show"]();
		}
	});
	
	/**
	 * POP BOXES (MENUS)
	 * -------------------------------------------------------------------------------------------------
	 */
	$(document).on("click mouseenter", ".pop-btn", function(e) {
				
		var $this_click = $(e.target),
			$pop_btn, $pop_box;
		
		if(e.type=="mouseenter" && !$(this).hasClass("pop-btn-auto")) return;
		if($(this).hasClass("disabled") || $this_click.closest("li.current").exists()) return;
		
		PF.fn.growl.close();
		
		e.stopPropagation();
		
		$pop_btn = $(this);		
		$pop_box = $(".pop-box", $pop_btn);
		$pop_btn.addClass("opened");
		
		if($pop_box.hasClass("anchor-center")){
			$pop_box.css("margin-left", -($pop_box.width()/2));
		}
		
		// Pop button changer
		if($this_click.is("[data-change]")){
			$("li", $pop_box).removeClass("current");
			$this_click.closest("li").addClass("current");
			$("[data-text-change]", $pop_btn).text($("li.current a", $pop_box).text());
			//PF.fn.growl.call($pop_btn.closest(".header").find(".content-tabs .current a").data("ajax")+" | Con-> "+$this_click.data("change"));
			e.preventDefault();
		}
		
		// Click inside the bubble only for .pop-keep-click
		if($pop_box.is(":visible") && $(e.target).closest(".pop-box-inner").length > 0 && $(this).is(".pop-keep-click")){
			return; 
		}

		$(".pop-box:visible").not($pop_box).hide().closest(".pop-btn").removeClass("opened");
		
		$pop_box.toggle();
		
		if(!$pop_box.is(":visible")){
			$pop_box.closest(".pop-btn").removeClass("opened");
		} else {
			$(".antiscroll-wrap:not(.jsly):visible", $pop_box).addClass("jsly").antiscroll();
		}
		
	}).on("mouseleave", ".pop-btn", function(){
		var $pop_btn, $pop_box;
		$pop_btn = $(this);		
		$pop_box = $(".pop-box", $pop_btn);
		
		if(!$(this).hasClass("pop-btn-auto")) return;
		$pop_box.hide().closest(".pop-btn").removeClass("opened");
	});
	
	/**
	 * TABS
	 * -------------------------------------------------------------------------------------------------
	 */
	
	// Hash on load (static tabs) changer
	if(window.location.hash){
		
		var $hash_node = $("[href="+ window.location.hash +"]");
		
		if($hash_node.exists()) {
			$.each($("[href="+ window.location.hash +"]")[0].attributes, function(){
				PF.obj.tabs.hashdata[this.name] = this.value;
			});
			PF.obj.tabs.hashdata.pushed = "tabs";
			
			History.replaceState({
				href: window.location.hash,
				"data-tab": $("[href="+ window.location.hash +"]").data("tab"),
				pushed: "tabs",
				statenum: 0
			}, null, null);
		}
		
	}
	
	// Stock tab onload data
	if($(".content-tabs").exists() && !window.location.hash) {
		var $tab = $("a", ".content-tabs .current");
		History.replaceState({
			href: $tab.attr("href"),
			"data-tab": $tab.data("tab"),
			pushed: "tabs",
			statenum: 0
		}, null, null);
	}
	
	// Keep scroll position (history.js)
	var State = History.getState();
	if(typeof State.data == "undefined") {
		History.replaceState({scrollTop: 0}, document.title, window.location.href); // Stock initial scroll
	}
	History.Adapter.bind(window,"popstate", function(){
		var State = History.getState();
		if(State.data && typeof State.data.scrollTop !== "undefined") {
			if($(window).scrollTop() !== State.data.scrollTop) {
				$(window).scrollTop(State.data.scrollTop);
			}
		}
		return;
	});
	
	// Toggle tab display
	$("a", ".content-tabs").click(function(e) {

		if($(this).data("link") == true) {
			$(this).data("tab", false);
		}

		if($(this).closest(".current,.disabled").exists()){
			e.preventDefault();
			return;
		}	
		if(typeof $(this).data("tab") == "undefined") return;
		
		var dataTab = {};
		$.each(this.attributes, function(){
			dataTab[this.name] = this.value;
		});
		dataTab.pushed = "tabs";
		
		// This helps to avoid issues on ?same and ?same#else
		dataTab.statenum = 0;
		if(History.getState().data && typeof History.getState().data.statenum !== "undefined") {
			dataTab.statenum = History.getState().data.statenum + 1
		}
		
		if($(this).attr("href") && $(this).attr("href").indexOf("#") === 0) {  // to ->#Hash
			PF.obj.tabs.hashdata = dataTab;
			if(typeof e.originalEvent == "undefined") {
				window.location.hash = PF.obj.tabs.hashdata.href.substring(1);
			}
		} else { // to ->?anything
			History.pushState(dataTab, document.title, $(this).attr("href"));
			e.preventDefault();
		}
		
	});
	
	// On state change bind tab changes
	$(window).bind("statechange hashchange", function(e) {
		
		PF.fn.growl.close();
		
		var dataTab;

		if(e.type == "statechange"){

			dataTab = History.getState().data;
		
		} else if(e.type == "hashchange"){

			if(typeof PF.obj.tabs.hashdata !== "undefined" && typeof PF.obj.tabs.hashdata.href !== "undefined" && PF.obj.tabs.hashdata.href !== window.location.hash) {
				PF.obj.tabs.hashdata = null;
			}
			
			if(PF.obj.tabs.hashdata == null) {
				var $target = $("[href="+ window.location.hash +"]", ".content-tabs");
				
				if(!$target.exists()) $target = $(window.location.hash);
				if(!$target.exists()) $target = $("a", ".content-tabs").first();
				
				if(typeof $target.data("tab") !== "undefined") {
					PF.obj.tabs.hashdata = {};
					$.each($target[0].attributes, function(){
						PF.obj.tabs.hashdata[this.name] = this.value;
					});
					PF.obj.tabs.hashdata.pushed = "tabs";
				}
			}
			
			dataTab = (typeof PF.obj.tabs.hashdata !== "undefined") ? PF.obj.tabs.hashdata : null;
			
		}
		
		if(dataTab && dataTab.pushed == "tabs"){
			PF.fn.show_tab(dataTab["data-tab"]);
		}
		
	});
	
	/**
	 * LISTING
	 * -------------------------------------------------------------------------------------------------
	 */
	
	// Stock the scroll position on list element click
	$(document).on("click", ".list-item a", function(e) {
		if($(this).attr("src") == "") return;
		History.replaceState({scrollTop: $(window).scrollTop()}, document.title, window.location.href);
	});
	
	// Load more (listing +1 page)
	$(document).on("click", "[data-action=load-more]", function(e){
		
		if(!PF.fn.is_listing() || $(this).closest(PF.obj.listing.selectors.content_listing).is(":hidden") || $(this).closest("#content-listing-template").exists() || PF.obj.listing.calling) return;
		
		PF.fn.listing.queryString.stock_new();
		
		// Page hack
		PF.obj.listing.query_string.page = $(PF.obj.listing.selectors.content_listing_visible).data("page");
		PF.obj.listing.query_string.page++;
		
		// Offset hack
		var offset = $(PF.obj.listing.selectors.content_listing_visible).data("offset");
		
		if(typeof offset !== "undefined") {
			PF.obj.listing.query_string.offset = offset;
			if(typeof PF.obj.listing.hidden_params == "undefined") {
				PF.obj.listing.hidden_params = {};
			}
			PF.obj.listing.hidden_params.offset = offset;
		} else {
			if(typeof PF.obj.listing.query_string.offset !== "undefined") {
				delete PF.obj.listing.query_string.offset;
			}
			if(PF.obj.listing.hidden_params && typeof PF.obj.listing.hidden_params.offset !== "undefined") {
				delete PF.obj.listing.hidden_params.offset;
			}
		}
		
		PF.fn.listing.ajax();
		e.preventDefault();

	});
	
	// List found on load html -> Do the columns!
	if($(PF.obj.listing.selectors.list_item).length > 0){
		
		PF.fn.listing.show();
				
		// Bind the infinte scroll
		$(window).scroll(function() {
		 
            if(($(window).scrollTop() + $(window).height() > $(document).height() - 200) && PF.obj.listing.calling == false) {
				$(PF.obj.listing.selectors.content_listing_visible).find(PF.obj.listing.selectors.content_listing_pagination).find("[data-action=load-more]").click();
            }
        });
		
	}
	
	// Multi-selection tools
	$(document).on("click", PF.obj.modal.selectors.root+ " [data-switch]", function(){
		var $this_modal = $(this).closest(PF.obj.modal.selectors.root);
		$("[data-view=switchable]", $this_modal).hide();
		$("#"+$(this).attr("data-switch"), $this_modal).show();
	});
	
});
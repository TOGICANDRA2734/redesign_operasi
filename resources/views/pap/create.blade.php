@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
    @if(Auth::user()->hasRole(['super_admin','admin']))
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Transaksi PAP</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 ">
            <!-- BEGIN: Form Layout -->
            <form action="{{route('super_admin.pap.store')}}" method="POST" class="intro-y box p-5" enctype="multipart/form-data">
                @csrf
                <!-- BEGIN: Form Input FIle -->
                <div class="mt-3">
                    <label>Site</label>
                    <!-- BEGIN: Basic Select -->
                    <div class="mt-2"> 
                        <select id="site" data-placeholder="Pilih site" name="site" class="tom-select w-full @error('site') border-danger @enderror">
                            <option value="" selected disabled>Pilih Site</option>
                            @foreach($site as $st)
                            <option value="{{$st->kodesite}}">{{$st->namasite}} - {{$st->lokasi}}</option>
                            @endforeach
                        </select> 
                        @error('site')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </div>
                    <!-- END: Basic Select -->
                </div>

                <div class="mt-3">
                    <label>Code Unit</label>
                    <!-- BEGIN: Basic Select -->
                    <div class="mt-2"> 
                        <select id="nom_unit" data-placeholder="Pilih Code Unit" name="nom_unit" class=" w-full @error('nom_unit') border-danger @enderror">
                            <option value="" selected disabled>Pilih Unit</option>
                        </select> 
                        @error('nom_unit')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </div>
                    <!-- END: Basic Select -->
                </div>

                <div class="mt-3">
                    <label>Kompartemen</label>
                    <!-- BEGIN: Basic Select -->
                    <div class="mt-2"> 
                        <select id="kompartemen" data-placeholder="Pilih Kompartemen" name="kompartemen" class="w-full @error('kompartemen') border-danger @enderror">
                            <option value="" selected disabled>Pilih Kompartemen</option>
                        </select> 
                        @error('kompartemen')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </div>
                    <!-- END: Basic Select -->
                </div>

                <div class="mt-3">
                    <label for="file_pap">File PAP (PDF)</label>
                    <div class="mt-2">
                        <input type="file" id="file_pap" name="file_pap" class="w-full @error('site') border-danger @enderror"/>
                        <!-- <input name="file_pap" id="file_pap" type="file" class="form-control @error('file_pap') border-danger @enderror}}" /> 
                        @error('file_pap')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif -->
                    </div>
                </div>
                <!-- END: Form Input File -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-lg btn-primary w-full mr-1 mb-2 mt-2">Submit</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
    @endif
@endsection

@section('script')
    <script src="{{ asset('dist/js/ckeditor-classic.js') }}"></script>
    <!-- <script>
        const inputElement = document.querySelector('input[id="file_pap"]');
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            server: {
                url: 'http://127.0.0.1:8000/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }
        })
    </script> -->
    <script>
        var $j = jQuery.noConflict();


        $j('#nom_unit').on('change', function(){
            console.log($j(this).val());
            var nom_unit = $j(this).val();
            let token = $j('meta[name="csrf-token"]').attr('content');

            if(nom_unit) {
                $j.ajax({
                    url: 'http://127.0.0.1:8000/pap-get-bagian',
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: token,
                        nom_unit: nom_unit
                    },
                    success:function(response)
                    {
                        if(response){
                            console.log('helo')
                        $j('#kompartemen').empty();
                        fullText = ""
                        fullText += '<option value="" selected disabled>Pilih Kompartemen</option>'; 
                        
                        $j.each(response, function(key){
                            text = '<option value="'+ response[key]['id'] +'">' + response[key]['bagian'] + '</option>';
                            console.log('halo', key, response[key]['id'], response[key]['bagian'])
                            fullText += text;
                        });
                        console.log(fullText);

                        $j("#kompartemen").append(fullText);
                        show_data();
                    }else{
                        console.log("heloo")
                        $j('#kompartemen').empty();
                    }
                    }
                });
            }else{
                $j('#kompartemen').empty();
            }
        })

        $j('#site').on('change', function(){
            console.log($j(this).val());
            var site = $j(this).val();
            let token = $j('meta[name="csrf-token"]').attr('content');

            if(site) {
                $j.ajax({
                    url: 'http://127.0.0.1:8000/pap-get-bagian',
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: token,
                        site: site
                    },
                    success:function(response)
                    {
                        if(response){
                            console.log('helo')
                        $j('#nom_unit').empty();
                        fullText = ""
                        fullText += '<option value="" selected disabled>Pilih nom_unit</option>'; 
                        
                        $j.each(response, function(key){
                            text = '<option value="'+ response[key]['nom_unit'] +'">' + response[key]['nom_unit'] + '</option>';
                            console.log('halo', key, response[key]['nom_unit'], response[key]['nom_unit'])
                            fullText += text;
                        });
                        console.log(fullText);

                        $j("#nom_unit").append(fullText);
                        show_data();
                    }else{
                        console.log("heloo")
                        $j('#nom_unit').empty();
                    }
                    }
                });
            }else{
                $j('#nom_unit').empty();
            }
        })

        function show_data() {
            Toastify({
                node: $("#success-notification-content")
                    .clone()
                    .removeClass("hidden")[0],
                duration: 10000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
        };
    </script>
    <script>
        /*!
         * Toastify js 1.12.0
         * https://github.com/apvarun/toastify-js
         * @license MIT licensed
         *
         * Copyright (C) 2018 Varun A P
         */
        (function(root, factory) {
            if (typeof module === "object" && module.exports) {
                module.exports = factory();
            } else {
                root.Toastify = factory();
            }
        })(this, function(global) {
            // Object initialization
            var Toastify = function(options) {
                    // Returning a new init object
                    return new Toastify.lib.init(options);
                },
                // Library version
                version = "1.12.0";

            // Set the default global options
            Toastify.defaults = {
                oldestFirst: true,
                text: "Toastify is awesome!",
                node: undefined,
                duration: 3000,
                selector: undefined,
                callback: function() {},
                destination: undefined,
                newWindow: false,
                close: false,
                gravity: "toastify-top",
                positionLeft: false,
                position: '',
                backgroundColor: '',
                avatar: "",
                className: "",
                stopOnFocus: true,
                onClick: function() {},
                offset: {
                    x: 0,
                    y: 0
                },
                escapeMarkup: true,
                ariaLive: 'polite',
                style: {
                    background: ''
                }
            };

            // Defining the prototype of the object
            Toastify.lib = Toastify.prototype = {
                toastify: version,

                constructor: Toastify,

                // Initializing the object with required parameters
                init: function(options) {
                    // Verifying and validating the input object
                    if (!options) {
                        options = {};
                    }

                    // Creating the options object
                    this.options = {};

                    this.toastElement = null;

                    // Validating the options
                    this.options.text = options.text || Toastify.defaults.text; // Display message
                    this.options.node = options.node || Toastify.defaults.node; // Display content as node
                    this.options.duration = options.duration === 0 ? 0 : options.duration || Toastify.defaults
                        .duration; // Display duration
                    this.options.selector = options.selector || Toastify.defaults.selector; // Parent selector
                    this.options.callback = options.callback || Toastify.defaults
                        .callback; // Callback after display
                    this.options.destination = options.destination || Toastify.defaults
                        .destination; // On-click destination
                    this.options.newWindow = options.newWindow || Toastify.defaults
                        .newWindow; // Open destination in new window
                    this.options.close = options.close || Toastify.defaults.close; // Show toast close icon
                    this.options.gravity = options.gravity === "bottom" ? "toastify-bottom" : Toastify.defaults
                        .gravity; // toast position - top or bottom
                    this.options.positionLeft = options.positionLeft || Toastify.defaults
                        .positionLeft; // toast position - left or right
                    this.options.position = options.position || Toastify.defaults
                        .position; // toast position - left or right
                    this.options.backgroundColor = options.backgroundColor || Toastify.defaults
                        .backgroundColor; // toast background color
                    this.options.avatar = options.avatar || Toastify.defaults
                        .avatar; // img element src - url or a path
                    this.options.className = options.className || Toastify.defaults
                        .className; // additional class names for the toast
                    this.options.stopOnFocus = options.stopOnFocus === undefined ? Toastify.defaults
                        .stopOnFocus : options.stopOnFocus; // stop timeout on focus
                    this.options.onClick = options.onClick || Toastify.defaults.onClick; // Callback after click
                    this.options.offset = options.offset || Toastify.defaults.offset; // toast offset
                    this.options.escapeMarkup = options.escapeMarkup !== undefined ? options.escapeMarkup :
                        Toastify.defaults.escapeMarkup;
                    this.options.ariaLive = options.ariaLive || Toastify.defaults.ariaLive;
                    this.options.style = options.style || Toastify.defaults.style;
                    if (options.backgroundColor) {
                        this.options.style.background = options.backgroundColor;
                    }

                    // Returning the current object for chaining functions
                    return this;
                },

                // Building the DOM element
                buildToast: function() {
                    // Validating if the options are defined
                    if (!this.options) {
                        throw "Toastify is not initialized";
                    }

                    // Creating the DOM object
                    var divElement = document.createElement("div");
                    divElement.className = "toastify on " + this.options.className;

                    // Positioning toast to left or right or center
                    if (!!this.options.position) {
                        divElement.className += " toastify-" + this.options.position;
                    } else {
                        // To be depreciated in further versions
                        if (this.options.positionLeft === true) {
                            divElement.className += " toastify-left";
                            console.warn(
                                'Property `positionLeft` will be depreciated in further versions. Please use `position` instead.'
                            )
                        } else {
                            // Default position
                            divElement.className += " toastify-right";
                        }
                    }

                    // Assigning gravity of element
                    divElement.className += " " + this.options.gravity;

                    if (this.options.backgroundColor) {
                        // This is being deprecated in favor of using the style HTML DOM property
                        console.warn(
                            'DEPRECATION NOTICE: "backgroundColor" is being deprecated. Please use the "style.background" property.'
                        );
                    }

                    // Loop through our style object and apply styles to divElement
                    for (var property in this.options.style) {
                        divElement.style[property] = this.options.style[property];
                    }

                    // Announce the toast to screen readers
                    if (this.options.ariaLive) {
                        divElement.setAttribute('aria-live', this.options.ariaLive)
                    }

                    // Adding the toast message/node
                    if (this.options.node && this.options.node.nodeType === Node.ELEMENT_NODE) {
                        // If we have a valid node, we insert it
                        divElement.appendChild(this.options.node)
                    } else {
                        if (this.options.escapeMarkup) {
                            divElement.innerText = this.options.text;
                        } else {
                            divElement.innerHTML = this.options.text;
                        }

                        if (this.options.avatar !== "") {
                            var avatarElement = document.createElement("img");
                            avatarElement.src = this.options.avatar;

                            avatarElement.className = "toastify-avatar";

                            if (this.options.position == "left" || this.options.positionLeft === true) {
                                // Adding close icon on the left of content
                                divElement.appendChild(avatarElement);
                            } else {
                                // Adding close icon on the right of content
                                divElement.insertAdjacentElement("afterbegin", avatarElement);
                            }
                        }
                    }

                    // Adding a close icon to the toast
                    if (this.options.close === true) {
                        // Create a span for close element
                        var closeElement = document.createElement("button");
                        closeElement.type = "button";
                        closeElement.setAttribute("aria-label", "Close");
                        closeElement.className = "toast-close";
                        closeElement.innerHTML = "&#10006;";

                        // Triggering the removal of toast from DOM on close click
                        closeElement.addEventListener(
                            "click",
                            function(event) {
                                event.stopPropagation();
                                this.removeElement(this.toastElement);
                                window.clearTimeout(this.toastElement.timeOutValue);
                            }.bind(this)
                        );

                        //Calculating screen width
                        var width = window.innerWidth > 0 ? window.innerWidth : screen.width;

                        // Adding the close icon to the toast element
                        // Display on the right if screen width is less than or equal to 360px
                        if ((this.options.position == "left" || this.options.positionLeft === true) && width >
                            360) {
                            // Adding close icon on the left of content
                            divElement.insertAdjacentElement("afterbegin", closeElement);
                        } else {
                            // Adding close icon on the right of content
                            divElement.appendChild(closeElement);
                        }
                    }

                    // Clear timeout while toast is focused
                    if (this.options.stopOnFocus && this.options.duration > 0) {
                        var self = this;
                        // stop countdown
                        divElement.addEventListener(
                            "mouseover",
                            function(event) {
                                window.clearTimeout(divElement.timeOutValue);
                            }
                        )
                        // add back the timeout
                        divElement.addEventListener(
                            "mouseleave",
                            function() {
                                divElement.timeOutValue = window.setTimeout(
                                    function() {
                                        // Remove the toast from DOM
                                        self.removeElement(divElement);
                                    },
                                    self.options.duration
                                )
                            }
                        )
                    }

                    // Adding an on-click destination path
                    if (typeof this.options.destination !== "undefined") {
                        divElement.addEventListener(
                            "click",
                            function(event) {
                                event.stopPropagation();
                                if (this.options.newWindow === true) {
                                    window.open(this.options.destination, "_blank");
                                } else {
                                    window.location = this.options.destination;
                                }
                            }.bind(this)
                        );
                    }

                    if (typeof this.options.onClick === "function" && typeof this.options.destination ===
                        "undefined") {
                        divElement.addEventListener(
                            "click",
                            function(event) {
                                event.stopPropagation();
                                this.options.onClick();
                            }.bind(this)
                        );
                    }

                    // Adding offset
                    if (typeof this.options.offset === "object") {

                        var x = getAxisOffsetAValue("x", this.options);
                        var y = getAxisOffsetAValue("y", this.options);

                        var xOffset = this.options.position == "left" ? x : "-" + x;
                        var yOffset = this.options.gravity == "toastify-top" ? y : "-" + y;

                        divElement.style.transform = "translate(" + xOffset + "," + yOffset + ")";

                    }

                    // Returning the generated element
                    return divElement;
                },

                // Displaying the toast
                showToast: function() {
                    // Creating the DOM object for the toast
                    this.toastElement = this.buildToast();

                    // Getting the root element to with the toast needs to be added
                    var rootElement;
                    if (typeof this.options.selector === "string") {
                        rootElement = document.getElementById(this.options.selector);
                    } else if (this.options.selector instanceof HTMLElement || (typeof ShadowRoot !==
                            'undefined' && this.options.selector instanceof ShadowRoot)) {
                        rootElement = this.options.selector;
                    } else {
                        rootElement = document.body;
                    }

                    // Validating if root element is present in DOM
                    if (!rootElement) {
                        throw "Root element is not defined";
                    }

                    // Adding the DOM element
                    var elementToInsert = Toastify.defaults.oldestFirst ? rootElement.firstChild : rootElement
                        .lastChild;
                    rootElement.insertBefore(this.toastElement, elementToInsert);

                    // Repositioning the toasts in case multiple toasts are present
                    Toastify.reposition();

                    if (this.options.duration > 0) {
                        this.toastElement.timeOutValue = window.setTimeout(
                            function() {
                                // Remove the toast from DOM
                                this.removeElement(this.toastElement);
                            }.bind(this),
                            this.options.duration
                        ); // Binding `this` for function invocation
                    }

                    // Supporting function chaining
                    return this;
                },

                hideToast: function() {
                    if (this.toastElement.timeOutValue) {
                        clearTimeout(this.toastElement.timeOutValue);
                    }
                    this.removeElement(this.toastElement);
                },

                // Removing the element from the DOM
                removeElement: function(toastElement) {
                    // Hiding the element
                    // toastElement.classList.remove("on");
                    toastElement.className = toastElement.className.replace(" on", "");

                    // Removing the element from DOM after transition end
                    window.setTimeout(
                        function() {
                            // remove options node if any
                            if (this.options.node && this.options.node.parentNode) {
                                this.options.node.parentNode.removeChild(this.options.node);
                            }

                            // Remove the element from the DOM, only when the parent node was not removed before.
                            if (toastElement.parentNode) {
                                toastElement.parentNode.removeChild(toastElement);
                            }

                            // Calling the callback function
                            this.options.callback.call(toastElement);

                            // Repositioning the toasts again
                            Toastify.reposition();
                        }.bind(this),
                        400
                    ); // Binding `this` for function invocation
                },
            };

            // Positioning the toasts on the DOM
            Toastify.reposition = function() {

                // Top margins with gravity
                var topLeftOffsetSize = {
                    top: 15,
                    bottom: 15,
                };
                var topRightOffsetSize = {
                    top: 15,
                    bottom: 15,
                };
                var offsetSize = {
                    top: 15,
                    bottom: 15,
                };

                // Get all toast messages on the DOM
                var allToasts = document.getElementsByClassName("toastify");

                var classUsed;

                // Modifying the position of each toast element
                for (var i = 0; i < allToasts.length; i++) {
                    // Getting the applied gravity
                    if (containsClass(allToasts[i], "toastify-top") === true) {
                        classUsed = "toastify-top";
                    } else {
                        classUsed = "toastify-bottom";
                    }

                    var height = allToasts[i].offsetHeight;
                    classUsed = classUsed.substr(9, classUsed.length - 1)
                    // Spacing between toasts
                    var offset = 15;

                    var width = window.innerWidth > 0 ? window.innerWidth : screen.width;

                    // Show toast in center if screen with less than or equal to 360px
                    if (width <= 360) {
                        // Setting the position
                        allToasts[i].style[classUsed] = offsetSize[classUsed] + "px";

                        offsetSize[classUsed] += height + offset;
                    } else {
                        if (containsClass(allToasts[i], "toastify-left") === true) {
                            // Setting the position
                            allToasts[i].style[classUsed] = topLeftOffsetSize[classUsed] + "px";

                            topLeftOffsetSize[classUsed] += height + offset;
                        } else {
                            // Setting the position
                            allToasts[i].style[classUsed] = topRightOffsetSize[classUsed] + "px";

                            topRightOffsetSize[classUsed] += height + offset;
                        }
                    }
                }

                // Supporting function chaining
                return this;
            };

            // Helper function to get offset.
            function getAxisOffsetAValue(axis, options) {

                if (options.offset[axis]) {
                    if (isNaN(options.offset[axis])) {
                        return options.offset[axis];
                    } else {
                        return options.offset[axis] + 'px';
                    }
                }

                return '0px';

            }

            function containsClass(elem, yourClass) {
                if (!elem || typeof yourClass !== "string") {
                    return false;
                } else if (
                    elem.className &&
                    elem.className
                    .trim()
                    .split(/\s+/gi)
                    .indexOf(yourClass) > -1
                ) {
                    return true;
                } else {
                    return false;
                }
            }

            // Setting up the prototype for the init object
            Toastify.lib.init.prototype = Toastify.lib;

            // Returning the Toastify function to be assigned to the window object/module
            return Toastify;
        });
    </script>
@endsection
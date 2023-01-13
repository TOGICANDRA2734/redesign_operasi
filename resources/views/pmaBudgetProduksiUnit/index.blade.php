@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
        <!-- BEGIN: Notification Content -->
    <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success"
        data-lucide="check-circle"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium">Data Berhasil Difilter!</div>
        </div>
    </div>
    <!-- END: Notification Content -->

    <div class="grid grid-cols-12 gap-5">
        <!-- Header -->
        <div class="flex justify-between items-center col-span-12 mt-5">
            <!-- Title -->
            <h2 class="text-lg font-medium truncate mr-5 ">
                PMA Budget Produksi Unit
            </h2>

            <div class="ml-auto flex justify-center items-center">
                <div class="mr-3 hidden" id="loading">
                    <i data-loading-icon="tail-spin" class="w-5 h-5"></i>
                </div>

                {{-- Url Rujukan --}}
                <input type="hidden" name="url" value="{{route('invoice-joint-survey.index')}}" id="urlFilter">

                {{-- Pilih Site --}}
                <select id="kodesite"
                    class="block shadow-sm p-2 mr-2 rounded-md w-20  text-sm dark:text-gray-300 dark-gray-600 dark:bg-gray-700 form-multiselect focus-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                    name="kodesite" id="kodesite">
                    <option value="">All Site</option>
                    @foreach ($site as $st)
                        <option value="{{ $st->kodesite }}">{{ $st->namasite }}</option>
                    @endforeach
                </select>

                {{-- Filter Tanggal --}}
                <div id="filterTanggal" class="form-control box p-2 ml-auto w-10 flex mr-2">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>

                <div class="dropdown">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4"
                                data-lucide="download"></i> </span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a href="" class="dropdown-item"> EXCEL </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"> PDF </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="col-span-12">


        <!-- Table -->
        <div class="w-full mb-8 col-span-12 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-auto h-[45rem]">
                <table class="w-full table table-sm">
                    <thead class="table-dark sticky left-0 top-0 z-50">
                        <tr class="">
                            <th rowspan="2" class="whitespace-nowrap text-center">Bulan</th>
                            <th colspan="2" class="whitespace-nowrap text-center">BUDGET</th>
                            <th colspan="2" class="whitespace-nowrap text-center">JOINT SURVEY</th>
                            <th colspan="2" class="whitespace-nowrap text-center">INVOICE</th>
                            <th colspan="2" class="whitespace-nowrap text-center">KETERCAPAIAN (%)</th>
                        </tr>
                        <tr>
                            <th class="whitespace-nowrap text-center">OB (BCM)</th>
                            <th class="whitespace-nowrap text-center">COAL (MT)</th>
                            <th class="whitespace-nowrap text-center">OB (BCM)</th>
                            <th class="whitespace-nowrap text-center">COAL (MT)</th>
                            <th class="whitespace-nowrap text-center">OB (BCM)</th>
                            <th class="whitespace-nowrap text-center">COAL (MT)</th>
                            <th class="whitespace-nowrap text-center">OB</th>
                            <th class="whitespace-nowrap text-center">COAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <script>
        var $j = jQuery.noConflict();

        var start = moment().subtract(29, 'days');
        var end = moment();

        // Overburden Range
        $j('#filterTanggal').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
                'Tahun Kemarin': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')
                ]
            }
        }, function(start, end, label) {
            var $j = jQuery.noConflict();
            var awal = start.format("YYYY-MM-DD");
            var akhir = end.format("YYYY-MM-DD");
            var kodesite = $j("#kodesite").val() ? $j("#kodesite").val() : "";
            $j("#loading").toggleClass('hidden');

            var url = $j("#urlFilter").val();
            console.log(url);

            if (awal !== null && akhir !== null) {
                $j.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        start: awal,
                        end: akhir,
                        kodesite: kodesite,
                    },
                    success: function(response) {
                        update_data(response)
                    },
                })
            }
        });
        
        // Pilih Site
        $j("#kodesite").on('change', function() {
            $j.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $j('meta[name="csrf-token"]').attr('content')
                }
            });

            var kodesite = $j("#kodesite").val() ? $j("#kodesite").val() : "";
            var awal = moment($j('#filterTanggal').data('daterangepicker').startDate).format("YYYY-MM-DD") ? moment($j('#filterTanggal').data('daterangepicker').startDate).format("YYYY-MM-DD") : "";
            var akhir = moment($j('#filterTanggal').data('daterangepicker').endDate).format("YYYY-MM-DD") ? moment($j('#filterTanggal').data('daterangepicker').endDate).format("YYYY-MM-DD") : "";
            console.log(awal,akhir)

            var url = $j("#urlFilter").val();

            $j("#loading").toggleClass('hidden');

            $j.ajax({
                type: "GET",
                url: url,
                data: {
                    'start': awal,
                    'end': akhir,
                    'kodesite': kodesite,
                },
                success: function(response) {
                    update_data(response)
                },
                error: function(result) {
                    console.log("error", result);
                },
            });
        });


        function update_data(response){
            console.log(response)

                        $j("#loading").toggleClass('hidden');

                        $j("table tbody").empty();
                        fullText = ""
                        if (response) {
                        console.log(response)

                        var i=1;
                        $j.each(response.data, function(index, data) {
                            var isLastElement = index == response.data.length -1;

                            nom_unit = (data['bulan'] == 'SUB TOTAL') ? "bg-gray-300 text-red-700 font-bold" : "bg-white";
                            text = "<tr class=\"text-center  " + nom_unit + "\">"

                            if(isLastElement){
                                data['bulan'] = "GRAND TOTAL"
                            }

                            // Add Index
                            // text += "<td class=\"whitespace-nowrap text-center\"> " + i + "</td>"

                            i++;
                            
                            $j.each(data, function(i, d){
                                if(i === 'bulan'){
                                    text += "<td class=\"whitespace-nowrap text-center\"> " + d + "</td>"                                    
                                } else if(i == 'ach_ob' || i == 'ach_coal'){
                                    text += "<td class=\"whitespace-nowrap text-center\"> " + number_format(d,1) + "</td>"
                                } else if (i == 'ob_bud' || i == 'coal_bud' || i == 'ob_js' || i == 'coal_js' || i == 'ob_inv' || i == 'coal_inv') {
                                    text += "<td class=\"whitespace-nowrap text-center\"> " + number_format(d,0) + "</td>"
                                }
                            })

                            text += "</tr>"
                            fullText += text
                        });
                        $j("table tbody").html(fullText);
                        show_data();
                    }
        }

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

        function number_format(number, decimals, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
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
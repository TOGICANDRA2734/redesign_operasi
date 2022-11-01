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

    <div class="">
        <!-- Header -->
        <div class="flex justify-between items-center py-4">
            <!-- Title -->
            <h2 class="text-lg font-medium truncate mr-5 ">
                Produksi Actual - {{ Auth::user()->kodesite != 'X' ? $site[0]->namasite : 'HO - All Site' }}
            </h2>


            <div class="ml-auto flex items-center">
                <i data-loading-icon="oval" class="w-7 h-7 mr-3 hidden" id="loading"></i> 
                <input type="month" name="pilihBulan" id="pilihBulan" class="shadow-sm border p-2 rounded-md w-30  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray">
                <input type="hidden" name="bulan" value="{{route('data-prod.index')}}" id="route">
                <!-- BEGIN: Notification Content -->
                <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
                    <div class="ml-4 mr-4">
                        <div class="font-medium">Data Berhasil Difilter!</div>
                    </div>
                </div> <!-- END: Notification Content -->
    
            </div>
        </div>
        <hr class="mb-10">

        <!-- Table -->
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full table table-striped table-sm">
                    <thead class="table-dark">
                        <tr class="">
                            <th rowspan="2" class="whitespace-nowrap text-center">Tanggal</th>
                            <th colspan="2" class="whitespace-nowrap text-center">Overburden</th>
                            <th colspan="2" class="whitespace-nowrap text-center">Coal</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">Aksi</th>
                        </tr>
                        <tr class="">
                            <th class="whitespace-nowrap text-center">Shift 1</th>
                            <th class="whitespace-nowrap text-center">Shift 2</th>
                            <th class="whitespace-nowrap text-center">Shift 1</th>
                            <th class="whitespace-nowrap text-center">Shift 2</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($period as $key => $dt)
                            <tr class="text-center bg-white">
                                <td class="whitespace-nowrap text-center">
                                    {{ date('d-m-Y', strtotime($dt)) }}
                                </td>
                                @foreach ($data[$key] as $keys => $dtS)
                                    @if ($keys !== 'id')
                                        <td class="whitespace-nowrap text-center">
                                            {{ $dtS }}
                                        </td>
                                    @endif
                                @endforeach
                                <td class="whitespace-nowrap text-center">
                                    <a href="{{ route('data-prod.edit', $dt) }}" class="btn btn-warning text-white"><i
                                            class="fa-solid fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <script>
        var $i = jQuery.noConflict();

        $i('#pilihBulan').on('change', function() {
        $i = jQuery.noConflict();
        $i.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $i('meta[name="csrf-token"]').attr('content')
            }
        });

        const pilihBulan = $i(this).val();
        var url = $("#route").val()

        $i.ajax({
            type: "POST",
            url: url,
            data: {
                'pilihBulan': pilihBulan,
            },
            success: function(result) {
                console.log(result.period[0]);

                $i("table tbody").empty();
                fullText = "";
                if (result) {
                    $i.each(result.data, function(index) {
                        text = '<tr class="text-center bg-white">' +
                            '<td class="">' + result.period[index] + '</td>' +
                            '<td class="">' + number_format(result.data[index].ob_s1,0) + '</td>' +
                            '<td class="">' + number_format(result.data[index].ob_s2,0) + '</td>' +
                            '<td class="">' + number_format(result.data[index].coal_s1,0) + '</td>' +
                            '<td class="">' + number_format(result.data[index].coal_s2,0) + '</td>' +
                            '<td class="">' + '<a href="http://ptrci.co.id/datacenter/public/data-prod/' + result.periodInput[index] +'/edit" class="btn btn-warning text-white"><i class="fa-solid fa-pencil"></i></a>' + '</td>' +
                            '</tr>';
                        fullText += text
                    });
                    $i("table tbody").html(fullText);
                    show_data()
                }
            },
            error: function(result) {
                console.log("error", result);
            },
        });
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

@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Populasi Unit
        </h2>
        @if(strtolower(Auth::user()->kodesite)=='x' or Auth::user()->hasRole('super_admin'))
        <div class="ml-auto mr-2 flex">
            <input type="text" name="cariNama" id="cariNama" placeholder="Cari Data" class="block shadow-sm border p-2 rounded-md w-30 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray mr-2">
            <select id="pilihSite" class="block shadow-sm border p-2 mr-0 rounded-md w-20  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                <option value="">All Site</option>
                @foreach($site as $st)
                <option value="{{$st->kodesite}}">{{$st->namasite}}</option>
                @endforeach
            </select>

            <!-- BEGIN: Notification Content -->
            <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
                <div class="ml-4 mr-4">
                    <div class="font-medium">Data Berhasil Difilter!</div>
                </div>
            </div> <!-- END: Notification Content -->

        </div>
        @endif
        <a href="{{route('super_admin.populasi-unit.create')}}" class="btn px-2 box mr-2">
            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
        </a>

        <div class="dropdown">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="download"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <form action="{{route('super_admin.export_data.index')}}" method="POST">

                            <button type="submit" class="dropdown-item"> Excel </button>
                        </form>
                    </li>
                    <li>
                        <a href="" class="dropdown-item"> PDF </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <hr class="mb-10">


    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full table table-striped text-xs">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">NO</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Nom Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Model</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">DO</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">SITE</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Type Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">S/N</th>
                        <th colspan="3" class="whitespace-nowrap text-center">Engine</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">HP</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Fuel</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">HM</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">KM</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">AKSI</th>
                    </tr>
                    <tr class="">
                        <th class="whitespace-nowrap text-center">Brand</th>
                        <th class="whitespace-nowrap text-center">Model</th>
                        <th class="whitespace-nowrap text-center">SN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $dt)
                    <tr class="bg-white text-center">
                        <td>{{$key+1}}</td>
                        @foreach($dt as $k => $d)
                            @if($k != 'id')
                            <td>{{$d}}</td>
                            @endif
                        @endforeach
                        <td class="cekTbModal">
                            <a href="{{route('super_admin.populasi-unit.show', $data[$key]->id)}}" class="btn btn-dark mr-1 mb-2">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
                            <a href="{{ route('super_admin.populasi-unit.edit', $data[$key]->id) }}" class="btn btn-warning mr-1 mb-2">
                                <i data-lucide="edit" class="w-5 h-5"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- BEGIN: Super Large Modal Content -->
<div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-5">
            <div class="modal-header">
                <h2 class="font-bold mb-2 text-xl">Data Unit</h2>

            </div>
            <div class="modal-body">

                <div class="overflow-y-auto max-h-[30rem]">
                    <div class="w-full overflow-y-auto sm:max-h-[20rem] mt-3 mb-3">
                        <div class="grid grid-cols-1 gap-5">
                        </div>
                        <div id="imageUnit" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        </div>

                        <table id='tableUnit' class="table table-striped sm:mt-2 table-auto">
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- END: Super Large Modal Content -->


<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $i = jQuery.noConflict();

    // Search by userid
    $i('.cekTbModal .tbDetail').on('click', function() {
        var userid = $i('.cekTbModal .tbDetail').val();
        console.log("Data rujuk",$i('.cekTbModal .tbDetail'));
        console.log("data:",userid);


        if (userid >= 0) {
            // AJAX POST request
            $i.ajax({
                url: '/super_admin/populasi-unit/showUser',
                type: 'post',
                data: {
                    _token: CSRF_TOKEN,
                    userid: userid
                },
                success: function(response) {
                    createRows(response);
                    console.log(response);
                }
            });
        }
    });

    // Create table rows
    function createRows(response) {
        var len = 0;
        $i('#tableUnit tbody').empty(); // Empty <tbody>
        $i('#imageUnit').empty(); // Empty <tbody>
        if (response['data'] != null) {
            len = response['data'].length;
        }

        if (len > 0) {
            var image =
                "<img class='rounded-md pb-3 w-full' src='https://images.unsplash.com/photo-1622645636770-11fbf0611463?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1473&q=80' alt=''/>" +
                "<img class='rounded-md pb-3 w-full' src='https://images.unsplash.com/photo-1622645636770-11fbf0611463?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1473&q=80' alt=''/>";
            $i("#imageUnit").append(image);

            var tr_str =
                "<tr class=''>" +
                "<th>NOM UNIT</th>" +
                "<td>" + response['data'][0].nom_unit + "</td>" +
                "</tr>" +
                "<tr class=''>" +
                "<th>DO</th>" +
                "<td>" + dateConverter(response['data'][0].DO) + "</td>" +
                "</tr>" +
                "<tr class=''>" +
                "<th>Height</th>" +
                "<td>" + response['data'][0].height + "</td>" +
                "</tr>" +
                "<tr class=''>" +
                "<th>Width</th>" +
                "<td>" + response['data'][0].width + "</td>" +
                "</tr>" +
                "<tr class=''>" +
                "<th>Length</th>" +
                "<td>" + response['data'][0].length + "</td>" +
                "</tr>";
            $i("#tableUnit tbody").append(tr_str);
        } else {
            var tr_str = "<tr>" +
                "<td align='center' colspan='" + response['data'].length + "'>No record found.</td>" +
                "</tr>";

            $i("#tableUnit tbody").append(tr_str);
        }
    }

    function dateConverter($value) {
        var date = $value.split('-');
        return date[2] + '-' + date[1] + '-' + date[0];
    }

    function monthDifference(d1, d2) {
        var months;
        months = (d2.getFullYear() - d1.getFullYear()) * 12;
        months -= d1.getMonth();
        months += d2.getMonth();
        return months;
    }
</script>

<!-- Filtering -->
<script>
    $i('#pilihSite').on('change', function() {
        $i = jQuery.noConflict();
        $i.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $i('meta[name="csrf-token"]').attr('content')
            }
        });

        var kodesite = $i(this).val();
        $bulan = new Date();
        const cariNama = $i('#cariNama').val() ? $i('#cariNama').val() : "";

        if (kodesite == null || kodesite == '') {
            kodesite = 'all';
        }

        console.log("PILIH Site", kodesite, cariNama);

        $i.ajax({
            type: "POST",
            url: '/super_admin/populasi_unit_filter?layout=side-menu',
            data: {
                'kodesite': kodesite,
                'cariNama': cariNama
            },
            success: function(result) {
                console.log(result)
                $i("table tbody").empty();
                fullText = ""
                if (result) {
                    i=0;
                    $i.each(result.data, function(index) {
                        i +=1;
                        text = '<tr class="text-center bg-white">' +
                            '<td class="">' + i + '</td>' +
                            '<td class="">' + result.data[index].nom_unit + '</td>' +
                            '<td class="">' + result.data[index].model + '</td>' +
                            '<td class="">' + result.data[index].DO + '</td>' +
                            '<td class="">' + result.data[index].namasite + '</td>' +
                            '<td class="">' + result.data[index].type_unit + '</td>' +
                            '<td class="">' + result.data[index].sn + '</td>' +
                            '<td class="">' + result.data[index].engine_brand + '</td>' +
                            '<td class="">' + result.data[index].engine_model + '</td>' +
                            '<td class="">' + result.data[index].engine_sn + '</td>' +
                            '<td class="">' + result.data[index].hp + '</td>' +
                            '<td class="">' + result.data[index].fuel + '</td>' +
                            '<td class="">' + result.data[index].HM + '</td>' +
                            '<td class="">' + result.data[index].KM + '</td>' +
                            '<td class="cekTbModal">' + 
                                '<a href="/super_admin/populasi-unit/'+result.data[index].id+'" class="btn btn-dark mr-1 mb-2">' + 
                                    '<i data-lucide="eye" class="w-5 h-5"></i>' + 
                                '</a>' + 
                                '<a href="/super_admin/populasi-unit/'+result.data[index].id+'/edit" class="btn btn-warning mr-1 mb-2">' + 
                                    '<i data-lucide="edit" class="w-5 h-5"></i>' + 
                                '</a>' + 
                            '</td>' + 
                            '</tr>';
                        fullText += text
                    });
                    $i("table tbody").html(fullText);
                    show_data();
                }
            },
            error: function(result) {
                console.log("error", result);
            },
        });
    })

    $i('#cariNama').on('change', function() {
        $i = jQuery.noConflict();
        $i.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $i('meta[name="csrf-token"]').attr('content')
            }
        });

        var kodesite = $i('#pilihSite').val();
        if (kodesite == null || kodesite == '') {
            kodesite = 'all';
        }
        const cariNama = $i(this).val();

        console.log("PILIH Nama", kodesite, cariNama);

        $i.ajax({
            type: "POST",
            url: '/super_admin/populasi_unit_filter?layout=side-menu',
            data: {
                'cariNama': cariNama,
                'kodesite': kodesite,
            },
            success: function(result) {
                $i("table tbody ").empty();
                fullText = ""
                if (result) {
                    i=0;
                    $i.each(result.data, function(index) {
                        i +=1;
                        text = '<tr class="text-center bg-white">' +
                            '<td class="">' + i + '</td>' +
                            '<td class="">' + result.data[index].nom_unit + '</td>' +
                            '<td class="">' + result.data[index].model + '</td>' +
                            '<td class="">' + result.data[index].DO + '</td>' +
                            '<td class="">' + result.data[index].namasite + '</td>' +
                            '<td class="">' + result.data[index].type_unit + '</td>' +
                            '<td class="">' + result.data[index].sn + '</td>' +
                            '<td class="">' + result.data[index].engine_brand + '</td>' +
                            '<td class="">' + result.data[index].engine_model + '</td>' +
                            '<td class="">' + result.data[index].engine_sn + '</td>' +
                            '<td class="">' + result.data[index].hp + '</td>' +
                            '<td class="">' + result.data[index].fuel + '</td>' +
                            '<td class="">' + result.data[index].HM + '</td>' +
                            '<td class="">' + result.data[index].KM + '</td>' +
                            '<td class="cekTbModal">' + 
                                '<a href="/super_admin/populasi-unit/'+result.data[index].id+'" class="btn btn-dark mr-1 mb-2">' + 
                                    '<i data-lucide="eye" class="w-5 h-5"></i>' + 
                                '</a>' + 
                                '<a href="/super_admin/populasi-unit/'+result.data[index].id+'/edit" class="btn btn-warning mr-1 mb-2">' + 
                                    '<i data-lucide="edit" class="w-5 h-5"></i>' + 
                                '</a>' + 
                            '</td>' + 
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
            duration: -1,
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
                this.options.duration = options.duration === 0 ? 0 : options.duration || Toastify.defaults.duration; // Display duration
                this.options.selector = options.selector || Toastify.defaults.selector; // Parent selector
                this.options.callback = options.callback || Toastify.defaults.callback; // Callback after display
                this.options.destination = options.destination || Toastify.defaults.destination; // On-click destination
                this.options.newWindow = options.newWindow || Toastify.defaults.newWindow; // Open destination in new window
                this.options.close = options.close || Toastify.defaults.close; // Show toast close icon
                this.options.gravity = options.gravity === "bottom" ? "toastify-bottom" : Toastify.defaults.gravity; // toast position - top or bottom
                this.options.positionLeft = options.positionLeft || Toastify.defaults.positionLeft; // toast position - left or right
                this.options.position = options.position || Toastify.defaults.position; // toast position - left or right
                this.options.backgroundColor = options.backgroundColor || Toastify.defaults.backgroundColor; // toast background color
                this.options.avatar = options.avatar || Toastify.defaults.avatar; // img element src - url or a path
                this.options.className = options.className || Toastify.defaults.className; // additional class names for the toast
                this.options.stopOnFocus = options.stopOnFocus === undefined ? Toastify.defaults.stopOnFocus : options.stopOnFocus; // stop timeout on focus
                this.options.onClick = options.onClick || Toastify.defaults.onClick; // Callback after click
                this.options.offset = options.offset || Toastify.defaults.offset; // toast offset
                this.options.escapeMarkup = options.escapeMarkup !== undefined ? options.escapeMarkup : Toastify.defaults.escapeMarkup;
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
                        console.warn('Property `positionLeft` will be depreciated in further versions. Please use `position` instead.')
                    } else {
                        // Default position
                        divElement.className += " toastify-right";
                    }
                }

                // Assigning gravity of element
                divElement.className += " " + this.options.gravity;

                if (this.options.backgroundColor) {
                    // This is being deprecated in favor of using the style HTML DOM property
                    console.warn('DEPRECATION NOTICE: "backgroundColor" is being deprecated. Please use the "style.background" property.');
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
                    if ((this.options.position == "left" || this.options.positionLeft === true) && width > 360) {
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

                if (typeof this.options.onClick === "function" && typeof this.options.destination === "undefined") {
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
                } else if (this.options.selector instanceof HTMLElement || (typeof ShadowRoot !== 'undefined' && this.options.selector instanceof ShadowRoot)) {
                    rootElement = this.options.selector;
                } else {
                    rootElement = document.body;
                }

                // Validating if root element is present in DOM
                if (!rootElement) {
                    throw "Root element is not defined";
                }

                // Adding the DOM element
                var elementToInsert = Toastify.defaults.oldestFirst ? rootElement.firstChild : rootElement.lastChild;
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
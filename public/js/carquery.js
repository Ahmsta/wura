$(document).ready(function () {
    // $('select').select2({
    //     theme: "classic",
    //     allowClear: true,
    //     selectOnClose: true,
    //     placeholder: 'Select an option'
    // });

    var d = new Date();
    var CarQuery = function() {};
    CarQuery.prototype = {
        cur_make: '',
        cur_trim: '',
        cur_year: '',
        minYear: 1914,
        cur_model: '',
        sold_in_us:'',
        maxYear: d.getFullYear(),
        color_int_select_id: null,
        model_data_id: 'modelData',
        year_select_id: 'car_year',
        make_select_id: 'car_type',
        default_trim_name:	"None",
        model_select_id: 'car_model',
        trim_select_id: 'car_model_trim',
        color_ext_select_id: 'car_model_color',
        base_url: "https://www.carqueryapi.com/api/0.3/",
        empty_option_html: 	"<option value=''>---</option>",
        init: 
            function() 
            {

                $.ajaxSetup({
                    "error":function() {   
                        Notify(wurafleet.toastType.Error, 'Bad Response from CarQuery API.\nThe service may not be avilable at this time.');
                        alert('Bad Response from CarQuery API.\nThe service may not be avilable at this time.');
                    }
                });

                this.populateYearSelect();

                var sender = this;
                
                // Set the change event for the years dropdown to populate the makes select
                $("select#" + this.year_select_id).bind('change', 
                    function() {
                        sender.yearSelectChange();
                    }
                );

                // Set the change event for the makes dropdown to populate the models select
                $("select#" + this.make_select_id).bind('change', 
                    function() {
                        sender.makeSelectChange();
                    }
                );
                
                // Set the change event for the models dropdown to save the selected model
                $("select#" + this.model_select_id).bind('change', 
                    function() {
                        sender.modelSelectChange();
                    }
                );
            },
        populateYearSelect: 
            function()
            {    
                var options = this.empty_option_html;

                // Set a loading message while we retrieve the data
                $("select#" + this.year_select_id).html("<option value=''>Loading Years...</option>");
                for (var i = this.maxYear; i >= this.minYear; i--)
                {
                    options += '<option value="' + i + '">' + i + '</option>';
                }
                
                $("select#" + this.year_select_id).html(options);
                $("select#" + this.make_select_id).html(this.empty_option_html);
                $("select#" + this.model_select_id).html(this.empty_option_html);
            },
        yearSelectChange: 
            function ()
            {
                this.cur_year = $("select#" + this.year_select_id).val();
                
                // If no year supplied, clear makes, models, return;
                if (this.cur_year == "")
                {
                    $("select#" + this.make_select_id).html(this.empty_option_html);
                    $("select#" + this.model_select_id).html(this.empty_option_html);
                    $("select#" + this.trim_select_id).html(this.empty_option_html);
                    return;
                }
                
                // Set a loading message while we retrieve the data
                $("select#" + this.make_select_id).html("<option value=''>Loading Makes...</option>");
                
                var sender = this;

                // Get Car Model JSON for the selected make
                $.getJSON(this.base_url + "?callback=?", {cmd:"getMakes", year:this.cur_year, sold_in_us:this.sold_in_us}, function(data) {
                    if(!$.isEmptyObject(data))
                    {
                        sender.populateMakeSelect(data);
                        sender.makeSelectChange();
                    }
                });
            },
        populateMakeSelect: 
            function(data)
            {
                if(!$.isEmptyObject(data))
                {
                    var options = '<option value="">Please choose a make</option>';
                    var makes = data.Makes;
                    for (var key in makes)
                    {
                        options += '<option value="' + makes[key].make_id + '">' + makes[key].make_display + '</option>';
                    }
                
                    $("select#" + this.make_select_id).html(options);
                }
            },
        makeSelectChange: 
            function ()
            {
                this.cur_make = $("select#" + this.make_select_id).val();
                
                // If no make supplied, clear models, return;
                if(this.cur_make == "")
                {
                    $("select#" + this.model_select_id).html(this.empty_option_html);
                    $("select#" + this.trim_select_id).html(this.empty_option_html);
                    return;
                }
            
                // Set a loading message while we retrieve the data
                $("select#" + this.model_select_id).html("<option value=''>Loading Models...</option>");
            
                var sender = this;
                
                // Get Car Model JSON for the selected make
                $.getJSON(this.base_url+"?callback=?", {cmd:"getModels", make:this.cur_make, year:this.cur_year, sold_in_us:this.sold_in_us}, function(data) {
                    if(!$.isEmptyObject(data))
                    {
                        sender.populateModelSelect(data);
                        sender.cur_model = $('select#' + sender.model_select_id).val();
                        // Re-populate the trim select
                        sender.modelSelectChange();
                    }
                });
            },
        populateModelSelect: 
            function(data)
            {    
                var models = data.Models;
            
                var options = '';
                for (var i = 0; i < models.length; i++)
                {
                    options += '<option value="' + models[i].model_name + '">' + models[i].model_name + '</option>';
                }
            
                $("select#" + this.model_select_id).html(options);
            },
        modelSelectChange: 
            function ()
            {
                this.cur_model = $("select#" + this.model_select_id).val();

                // If there is no trim select, we don't need to do anything else here
                if (this.trim_select_id == '' || this.trim_select_id == null) return;
                    
                // iI no model supplied, clear trim, return;
                if (this.cur_model == "")
                {
                    $("select#" + this.trim_select_id).html(this.empty_option_html);
                    return;
                }
                
                // Set a loading message while we retrieve the data
                $("select#" + this.trim_select_id).html("<option value=''>Loading Trims...</option>");
                
                var sender = this;
                
                // Get Car Model JSON for the selected make
                $.getJSON(this.base_url + "?callback=?", {cmd:"getTrims", make:this.cur_make, year:this.cur_year, model:this.cur_model, sold_in_us:this.sold_in_us, full_results:0 }, function(data) {
                    if(!$.isEmptyObject(data)) 
                    {
                        sender.populateTrimSelect(data);
                        sender.cur_trim = $('select#' + sender.trim_select_id).val();
                    }
                });
            },
        populateTrimSelect: 
            function(data)
            {    
                var display;
                var options = '';
                var trims = data.Trims;

                for (var i = 0; i < trims.length; i++)
                {
                    trim_display = trims[i].model_trim;
                    if (trim_display == "") {
                        trim_display = this.default_trim_name;
                    }
                    options += '<option value="' + trims[i].model_id + '">' +  trim_display + '</option>';
                }
                
                $("select#" + this.trim_select_id).html(options);
                
                this.cur_trim = $("select#" + this.trim_select_id).val();
                
                // If we have set color option dropdowns, populate them
                if (this.color_int_select_id != null || this.color_ext_select_id != null)
                {
                    this.populateColorSelects(this.cur_trim);
                }
            },
        populateColorSelects: 
            function(model_id)
            {
                var sender = this;
            
                $.getJSON(this.base_url+"?callback=?", {cmd:"getModel", model:model_id}, function(data) {
                    if (!$.isEmptyObject(data))
                    {
                        sender.carDataHTML(data[0]);
                        var intColors = data[0].IntColors;
                        var extColors = data[0].ExtColors;
                        var outInt = sender.empty_option_html;
                        var outExt = sender.empty_option_html;

                        for (var i = 0; i < intColors.length; i++)
                        {
                            outInt += "<option value=\"" + intColors[i].color_id + "\">" + intColors[i].color_name + "</option>";
                        }
                        
                        for (var i = 0; i < extColors.length; i++)
                        {
                            outExt += "<option value=\"" + extColors[i].color_id + "\">" + extColors[i].color_name + "</option>";
                        }

                        if (sender.color_int_select_id != null) 
                        { 
                            $('#' + sender.color_int_select_id).html(outInt);
                        }

                        if (sender.color_ext_select_id != null) 
                        { 
                            $('#'+sender.color_ext_select_id).html(outExt); 
                        }
                    }	    
                });
            },
        carDataHTML: 
            function(data)
            {
                var sold_in_us = "No";
                if (data.model_sold_in_us == "1") {
                    sold_in_us = "Yes";
                }
            
                var out = '<table class="model-data">';
                    
                out += '<tr><th colspan="2">'+data.model_year+' '+data.make_display+' '+data.model_name+' '+data.model_trim+'</th></tr>';
                    
                out += '<tr><td colspan="2"><hr/></td></tr>';	
                out += '<tr><td>Country of Origin:</td><td>'+data.make_country+'</td></tr>';
                out += '<tr><td>Sold in US:</td><td>'+sold_in_us+'</td></tr>';
                out += '<tr><td>Body Style:</td><td>'+data.model_body+'</td></tr>';
                
                // // Output Color Data
                // out += '<tr><td colspan="2"><hr/></td></tr>';
                // out += '<tr><td valign="top">Exterior Colors:</td><td>';
                // out += this.carColorHTML(data.ExtColors) + '</td></tr>';
                // out += '<tr><td valign="top">Interior Colors:</td><td>';
                // out += this.carColorHTML(data.IntColors) + '</td></tr>';
                    
                out += '<tr><td colspan="2"><hr/></td></tr>';
                out += '<tr><td>Engine Location:</td><td>'+data.model_engine_position+'</td></tr>';
                out += '<tr><td>Engine Type:</td><td>'+data.model_engine_type+'</td></tr>';
                out += '<tr><td>Engine Cylinders:</td><td>'+data.model_engine_cyl+'</td></tr>';
                out += '<tr><td>Engine Displacement (cc):</td><td>'+data.model_engine_cc+'</td></tr>';
                out += '<tr><td>Engine Displacement (l):</td><td>'+data.model_engine_l+'</td></tr>';
                out += '<tr><td>Engine Displacement (cubic inches):</td><td>'+data.model_engine_ci+'</td></tr>';
                out += '<tr><td>Engine Bore (mm):</td><td>'+data.model_engine_bore_mm+'</td></tr>';
                out += '<tr><td>Engine Bore (in):</td><td>'+data.model_engine_bore_in+'</td></tr>';
                out += '<tr><td>Engine Stroke (mm):</td><td>'+data.model_engine_stroke_mm+'</td></tr>';
                out += '<tr><td>Engine Stroke (in):</td><td>'+data.model_engine_stroke_in+'</td></tr>';
                out += '<tr><td>Engine Valves Per Cylinder:</td><td>'+data.model_engine_valves_per_cyl+'</td></tr>';
                out += '<tr><td>Engine Valves:</td><td>'+data.model_engine_valves+'</td></tr>';
                out += '<tr><td>Engine Max Power (HP):</td><td>'+data.model_engine_power_hp+'</td></tr>';
                out += '<tr><td>Engine Max Power (PS):</td><td>'+data.model_engine_power_ps+'</td></tr>';
                out += '<tr><td>Engine Max Power (kW):</td><td>'+data.model_engine_power_kw+'</td></tr>';
                out += '<tr><td>Engine Max Power RPM:</td><td>'+data.model_engine_power_rpm+'</td></tr>';
                out += '<tr><td>Engine Max Torque (Nm):</td><td>'+data.model_engine_torque_nm+'</td></tr>';
                out += '<tr><td>Engine Max Torque (Lb-Ft):</td><td>'+data.model_engine_torque_lbft+'</td></tr>';
                out += '<tr><td>Engine Max Torque (kgf-m):</td><td>'+data.model_engine_torque_kgm+'</td></tr>';
                out += '<tr><td>Engine Max Torque RPM:</td><td>'+data.model_engine_torque_rpm+'</td></tr>';
                out += '<tr><td>Engine Compression Ratio:</td><td>'+data.model_engine_compression+'</td></tr>';
                out += '<tr><td>Engine Fuel Type:</td><td>'+data.model_engine_fuel+'</td></tr>';
                    
                out += '<tr><td colspan="2"><hr/></td></tr>';
                out += '<tr><td>Drive:</td><td>'+data.model_drive+'</td></tr>';
                out += '<tr><td>Transmission Type:</td><td>'+data.model_transmission_type+'</td></tr>';
                out += '<tr><td>Top Speed (KPH):</td><td>'+data.model_top_speed_kph+'</td></tr>';
                out += '<tr><td>Top Speed (MPH):</td><td>'+data.model_top_speed_mph+'</td></tr>';
                out += '<tr><td>0-100 kph (0-62mph):</td><td>'+data.model_0_to_100_kph+'</td></tr>';
                    
                out += '<tr><td colspan="2"><hr/></td></tr>';
                out += '<tr><td>Doors:</td><td>'+data.model_doors+'</td></tr>';
                out += '<tr><td>Seats:</td><td>'+data.model_seats+'</td></tr>';
                out += '<tr><td>Weight (kg):</td><td>'+data.model_weight_kg+'</td></tr>';
                out += '<tr><td>Weight (lbs):</td><td>'+data.model_weight_lbs+'</td></tr>';
                out += '<tr><td>Length (mm):</td><td>'+data.model_length_mm+'</td></tr>';
                out += '<tr><td>Length (in):</td><td>'+data.model_length_in+'</td></tr>';
                out += '<tr><td>Width (mm):</td><td>'+data.model_width_mm+'</td></tr>';
                out += '<tr><td>Width (in):</td><td>'+data.model_width_in+'</td></tr>';
                out += '<tr><td>Height (mm):</td><td>'+data.model_height_mm+'</td></tr>';
                out += '<tr><td>Height (in):</td><td>'+data.model_height_in+'</td></tr>';
                out += '<tr><td>Wheelbase (mm):</td><td>'+data.model_wheelbase_mm+'</td></tr>';
                out += '<tr><td>Wheelbase (in):</td><td>'+data.model_wheelbase_in+'</td></tr>';
                out += '<tr><td>Fuel Economy City(l/100km):</td><td>'+data.model_lkm_city+'</td></tr>';
                out += '<tr><td>Fuel Economy City(mpg):</td><td>'+data.model_mpg_city+'</td></tr>';
                out += '<tr><td>Fuel Economy HWY(l/100km):</td><td>'+data.model_lkm_hwy+'</td></tr>';
                out += '<tr><td>Fuel Economy HWY(mpg):</td><td>'+data.model_mpg_hwy+'</td></tr>';
                out += '<tr><td>Fuel Economy Mixed(l/100km):</td><td>'+data.model_lkm_mixed+'</td></tr>';
                out += '<tr><td>Fuel Economy Mixed(mpg):</td><td>'+data.model_mpg_mixed+'</td></tr>';
                out += '<tr><td>Fuel Capacity(l):</td><td>'+data.model_fuel_cap_l+'</td></tr>';
                out += '<tr><td>Fuel Capacity(g):</td><td>'+data.model_fuel_cap_g+'</td></tr>';
                    
                out += '</table>';
                    
                out = out.replace(/>null</g, ">Not Available<");

                $("#" + this.model_data_id).html(out);
                $('#vehicle_info').data(JSON.stringify(data));
            },
    };

    // Create a variable for the CarQuery object.  You can call it whatever you like.
    var carquery = new CarQuery();

    // Run the carquery init function to get things started:
    carquery.init();
});
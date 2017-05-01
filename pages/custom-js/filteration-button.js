// filteration on the basis of changes in the filteration block on side bar after clicking on the option in filteration block 
 // started here........................................

$('#previous_month').change(function () {
  var month_value=document.getElementById('previous_month').value;
  document.getElementById('fi_previous_month').innerHTML =' Month -'+ month_value;
   $("#fi_previous_month").removeClass('hidden').addClass("fa fa-times",'visible');
   $("#li_previous_month").removeClass('visible').addClass('hidden');
});

$('#previous_year').change(function () {
  var year_value=document.getElementById('previous_year').value;
  document.getElementById('fi_previous_year').innerHTML =' year -'+ year_value;
   $("#fi_previous_year").removeClass('hidden').addClass("fa fa-times",'visible');
   $("#li_previous_year").removeClass('visible').addClass('hidden');
});

$('#onedate').change(function () {
  $('#fi_fromdate').removeClass('visible', 'fa fa-times').addClass('hidden');
  $('#fi_todate').removeClass('visible', 'fa fa-times').addClass('hidden');
  document.getElementById('fromdate').value='';
  document.getElementById('todate').value='';
  var one_value=document.getElementById('onedate').value;
  document.getElementById('fi_onedate').innerHTML =' Single date -'+ one_value;
   $("#fi_onedate").removeClass('hidden').addClass("fa fa-times",'visible');
   $("#li_one_date_filter").removeClass('visible').addClass('hidden');
   
});

$('#fromdate').change(function () {
  $("#fi_onedate").removeClass("fa fa-times",'visible').addClass('hidden');
  document.getElementById('onedate').value='';
  var from_value=document.getElementById('fromdate').value;
  document.getElementById('fi_fromdate').innerHTML =' From date -'+ from_value;
  $("#li_from_date_filter").removeClass('visible').addClass('hidden');
  $("#fi_fromdate").removeClass('hidden').addClass("fa fa-times",'visible');
});

$('#todate').change(function () {
  var to_value=document.getElementById('todate').value;
  document.getElementById('fi_todate').innerHTML =' To date -'+ to_value;
  $("#li_to_date_filter").removeClass('visible').addClass('hidden');
  $("#fi_todate").removeClass('hidden').addClass("fa fa-times",'visible');
});

$('#filter_by_choice_team').change(function () {
  var selectedText = $("#filter_by_choice_team option:selected").html();
  document.getElementById('fi_filter_by_choice_button').innerHTML =' '+ selectedText;
  $("#li_filter_by_choice_team").removeClass('visible').addClass('hidden');
  $("#fi_filter_by_choice_button").removeClass('hidden').addClass("fa fa-times",'visible');
});
// closed here changes event on filteration block on side bar.......................


// all filteration option action while clicking on that option in the side bar started here.......................

$('#month_filter').click(function() {
  $('#li_previous_month').removeClass('hidden').addClass('visible');
  $('#li_previous_year').removeClass('visible').addClass('hidden');
});
$('#year_filter').click(function() {
  $('#li_previous_year').removeClass('hidden').addClass('visible');
  $('#li_previous_month').removeClass('visible').addClass('hidden');
});

$('#single_date').click(function() {
  $('#li_one_date_filter').removeClass('hidden').addClass('visible');
  $('#li_from_date_filter').removeClass('visible').addClass('hidden');
  $('#li_to_date_filter').removeClass('visible').addClass('hidden');
});
$('#multiple_dates').click(function() {
  $('#li_one_date_filter').removeClass('visible').addClass('hidden');
  $('#li_from_date_filter').removeClass('hidden').addClass('visible');
  $('#li_to_date_filter').removeClass('hidden').addClass('visible');
});

$('#shift_filter').click(function() {
  $('#li_filter_by_choice_team').removeClass('visible').addClass('hidden');
  $('#li_filter_by_shift').removeClass('hidden').addClass('visible');
  $('#li_filter_by_team').removeClass('visible').addClass('hidden');
  
});
$('#team_filter').click(function() {
  $('#li_filter_by_choice_team').removeClass('visible').addClass('hidden');
  $('#li_filter_by_team').removeClass('hidden').addClass('visible');
  $('#li_filter_by_shift').removeClass('visible').addClass('hidden');
});
$('#id_filter').click(function() {
  $('#li_filter_by_team').removeClass('visible').addClass('hidden');
  $('#li_filter_by_shift').removeClass('visible').addClass('hidden');
  $('#li_filter_by_choice_team').removeClass('hidden').addClass('visible');
});
$('#name_filter').click(function() {
  $('#li_filter_by_choice_team').removeClass('hidden').addClass('visible');
  $('#li_filter_by_team').removeClass('visible').addClass('hidden');
  $('#li_filter_by_shift').removeClass('visible').addClass('hidden');
});


// filteration click action on radio button in closed here.........................................................

$('#filter_list_by_id').click(function() {
  $('#filter_list_by_name').prop('selectedIndex',0);
  $('#filter_by_choice_team').prop('selectedIndex',0);
  $("#filter_by_shift").prop('selectedIndex',0);
  $('#filter_by_team').prop('selectedIndex',0);
  $('#filter_list_by_manager_name').prop('selectedIndex',0);
  var value = document.getElementById('filter_by_role').value;
  if(value =="manager") {
    $("#filter_list_by_manager_button").removeClass("hidden").addClass("visible");
  }
  $('#onedate').value="";
  $('#fromdate').value="";
  $('#todate').value="";
});

$('#filter_by_role').click(function () {
  var value = document.getElementById('filter_by_role').value;
  if(value =='employee') {
   $("#filter_list_by_manager_button").removeClass("visible").addClass("hidden");
  }
  
  $('#onedate').value="";
  $('#fromdate').value="";
  $('#todate').value="";
});

$('#filter_list_by_name').click(function() {
  $('#filter_list_by_id').prop('selectedIndex',0);
  $('#filter_list_by_manager_name').prop('selectedIndex',0);
  $('#filter_by_choice_team').prop('selectedIndex',0);
  var value = document.getElementById('filter_by_role').value;
  if(value =="manager") {
    $("#filter_list_by_manager_button").removeClass("hidden").addClass("visible");
  }
  $('#onedate').value="";
  $('#fromdate').value="";
  $('#todate').value="";
});

$('#filter_by_choice_team').click(function () {
  $("#filter_list_by_id").prop('selectedIndex',0);
  $("#filter_list_by_name").prop('selectedIndex',0);

});

$('#filter_by_shift').click(function () {
  $("#filter_list_by_id").prop('selectedIndex',0);
  $("#filter_list_by_name").prop('selectedIndex',0);
  $("#filter_list_by_manager_button").removeClass("visible").addClass("hidden");
   $("#filter_by_choice_button").removeClass("hidden").addClass("visible");
   $('#onedate').value="";
  $('#fromdate').value="";
  $('#todate').value="";
});

$('#filter_by_team').click(function (){
  $('#filter_by_shift').prop('selectedIndex',0);
  $('#filter_list_by_name').prop('selectedIndex',0);
  $('#filter_by_choice_team').prop('selectedIndex',0);
  $("#filter_by_shift").prop('selectedIndex',0);
  $('#filter_list_by_manager_name').prop('selectedIndex',0);
   $("#filter_list_by_manager_button").removeClass("visible").addClass("hidden");
   $("#filter_by_choice_button").removeClass("hidden").addClass("visible");
   $('#onedate').value="";
  $('#fromdate').value="";
  $('#todate').value="";
});

$('#filter_list_by_manager_name').click(function () {
  $('#filter_list_by_id').prop('selectedIndex',0);
  $('#filter_list_by_name').prop('selectedIndex',0);
});

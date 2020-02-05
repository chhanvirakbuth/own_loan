$().ready(function() {

    $("#personal-info").validate();
    // get current date
      // var d = new Date();
      // var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
      // var strDate = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();
      // console.log(strDate);
      // $("#start_at").val(strDate);

    // input number as dicimal value
    $("#percent_rate").on("keypress keyup blur",function (event) {
           //this.value = this.value.replace(/[^0-9\.]/g,'');
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
           if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
               event.preventDefault();
           }
       });

      // input number only
       $("#your_friend_number").on("keypress keyup blur",function (event) {
          $(this).val($(this).val().replace(/[^\d].+/, ""));
           if ((event.which < 48 || event.which > 57)) {
               event.preventDefault();
           }
       });

       // input alphabet only
       $( "#latin_name" ).keypress(function(e) {
            var key = e.keyCode;
            if (key >= 48 && key <= 57) {
                e.preventDefault();
            }
            var ew = event.which;
            if(ew == 32)
                return true;
            if(48 <= ew && ew <= 57)
                return true;
            if(65 <= ew && ew <= 90)
                return true;
            if(97 <= ew && ew <= 122)
                return true;
            return false;
        });
    // add the rule here
 $.validator.addMethod("valueNotEquals", function(value, element, arg){
  return arg !== value;
 }, "Value must not equal arg.");
   // validate signup form on keyup and submit
    $("#signupForm").validate({
        rules: {
            full_name: "required",
            inlineradio: "required",
            occupation:{
                valueNotEquals: "default"
            },
            birth_of_date:{
                required: true
                // anyDate: true
            },
            id_card_number:{
                required: true,
                digits: false
            },
            status:{
                valueNotEquals: "default"
            },
            your_phone_number:{
                required: true,
                digits: false
            },
            provinces:{
                valueNotEquals: "default"
            },
            loan_type:{
                valueNotEquals: "default"
            },reason:{
                required: true
            },
            percent_rate:"required",
            begin_amount:{
                required: true,
                digits: false
            },

        },
        messages: {
            full_name:"សូមបញ្ចូលឈ្មោះពេញរបស់អ្នកខ្ចី",
            inlineradio:"សូមរើសភេទ",
            occupation:{
                valueNotEquals: "សូមជ្រើសរើសមុខរបរ"
            },
            birth_of_date:{
                required: "សូមបញ្ចូលថ្ងៃកំណើត"
                //anyDate:"សូមបញ្ចូលជាប្រភេទថ្ងៃ ខែ ឆ្នាំ"
            },
            id_card_number:{
                required: "សូមបញ្ចូលលេខអត្តសញ្ណាណប័ណ្ណ",
                digits: "អនុញ្ញាតបានតែលេខទេ"
            },
            status:{

                valueNotEquals: "សូមជ្រើសរើសស្ថានភាព"
            },
            your_phone_number:{
                required: "សូមបញ្ចូលលេខទូរស័ព្ទ",
                digits: "សូមបញ្ចូលជាប្រភេទលេខ"
            },
            provinces:{
                valueNotEquals: "សូមរើសខេត្ត "
            },
            loan_type:{

                valueNotEquals: "សូមជ្រើសរើសប្រភេទកម្ចី"
            },reason:{
                required: "សូមប្រាប់ពីមូលហេតុនៃការខ្ចី"
            },
            percent_rate:"សូមបំពេញការប្រាក់",
            begin_amount:{
                required: "សូមបញ្ចូលប្រាក់កម្ចី",
                digits: "បញ្ចូលចំនួនប្រាក់ត្រូវខ្ចី"
            }

        }
    });

    // validat EditForm
    // validate signup form on keyup and submit
     $("#EditForm").validate({
         rules: {
             full_name: "required",
             inlineradio: "required",
             occupation:{
                 valueNotEquals: "default"
             },
             birth_of_date:{
                 required: true
                 // anyDate: true
             },
             id_card_number:{
                 required: true,
                 digits: false
             },
             status:{
                 valueNotEquals: "default"
             },
             your_phone_number:{
                 required: true,
                 digits: false
             },
             provinces:{
                 valueNotEquals: "default"
             },
             loan_type:{
                 valueNotEquals: "default"
             },reason:{
                 required: true
             },
             percent_rate:"required",
             begin_amount:{
                 required: true,

             },

         },
         messages: {
             full_name:"សូមបញ្ចូលឈ្មោះពេញរបស់អ្នកខ្ចី",
             inlineradio:"សូមរើសភេទ",
             occupation:{
                 valueNotEquals: "សូមជ្រើសរើសមុខរបរ"
             },
             birth_of_date:{
                 required: "សូមបញ្ចូលថ្ងៃកំណើត"
                 //anyDate:"សូមបញ្ចូលជាប្រភេទថ្ងៃ ខែ ឆ្នាំ"
             },
             id_card_number:{
                 required: "សូមបញ្ចូលលេខអត្តសញ្ណាណប័ណ្ណ",
                 digits: "អនុញ្ញាតបានតែលេខទេ"
             },
             status:{

                 valueNotEquals: "សូមជ្រើសរើសស្ថានភាព"
             },
             your_phone_number:{
                 required: "សូមបញ្ចូលលេខទូរស័ព្ទ",
                 digits: "សូមបញ្ចូលជាប្រភេទលេខ"
             },
             provinces:{
                 valueNotEquals: "សូមរើសខេត្ត "
             },
             loan_type:{

                 valueNotEquals: "សូមជ្រើសរើសប្រភេទកម្ចី"
             },reason:{
                 required: "សូមប្រាប់ពីមូលហេតុនៃការខ្ចី"
             },
             percent_rate:"សូមបំពេញការប្រាក់",
             begin_amount:{
                 required: "សូមបញ្ចូលប្រាក់កម្ចី",

             }

         }
     });


    // date picker
    $("#birth_of_date, #start_at").flatpickr();

    // get Address

    // on click province loan districts
      $('#provinces').on('change',function(){
        var id =$(this).val();
        $.ajax({
          url:'/admin/address/districts/'+id,
          type:'GET',
          dataType:'json',
          success:function(data){
            $('#districts').empty();
            $('#communes').empty();
            $('#villages').empty();
            $('#districts').append('<option value="default">--សូមជ្រើសរើសស្រុក--</option>');

            $.each(data,function(key, value){
              $('#districts').append('<option value="'+key+'">'+value+'</option>');
            });
          }
        });
      });

      // on click districts change communes
      $('#districts').on('change',function(){
        var id =$(this).val();
        $.ajax({
          url:'/admin/address/communes/'+id,
          type:'GET',
          dataType:'json',
          success:function(data){
            $('#communes').empty();
            $('#villages').empty();
            $('#communes').append('<option value="default">--សូមជ្រើសរើសឃុំ--</option>');

            $.each(data,function(key, value){
              $('#communes').append('<option value="'+key+'">'+value+'</option>');
            });
          }
        });
      });

      // on click communes change villages
      $('#communes').on('change',function(){
        var id =$(this).val();
        $.ajax({
          url:'/admin/address/villages/'+id,
          type:'GET',
          dataType:'json',
          success:function(data){
            $('#villages').empty();
            $('#villages').append('<option value="default">--សូមជ្រើសរើសភូមិ--</option>');

            $.each(data,function(key, value){
              $('#villages').append('<option value="'+key+'">'+value+'</option>');
            });
          }
        });
      });

    // on change loan type load loan rate
    $('#loan_type').on('change',function(){
      var id=$(this).val();
      $.ajax({
          url:'/admin/loan/rate/'+id,
          type:'GET',
          dataType:'json',
          success:function(data){
            if(data){
              $('#percent_rate').empty();
              $.each(data,function(key,value){
              $('#percent_rate').val((value * 100) + ' %');

              });
            }
          }
        });
    });

});

"use strict";

// Class definition
var KTAccountReferralsReferralProgram = function () {
    // Private functions

    var initReferralProgrammClipboard = function () {
   

        //KASHEF ACCOUNTS == admin #Link
        var adminLinkBtn = document.querySelector('#kt_admin_link_copy_btn');
        var adminInputLink = document.querySelector('#kt_admin_referral_link_input');
        var adminLinkClipboard = new ClipboardJS(adminLinkBtn);
        adminLinkClipboard.on('success', function (e) {
            var buttonAdmin = adminLinkBtn.innerHTML;
            adminInputLink.classList.add('bg-success');
            adminInputLink.classList.add('text-inverse-success');
            adminLinkBtn.innerHTML = 'تم النسخ!';
            setTimeout(function () {
                adminLinkBtn.innerHTML = buttonAdmin;
                adminInputLink.classList.remove('bg-success');
                adminInputLink.classList.remove('text-inverse-success');
            }, 3000);  // 3seconds
            e.clearSelection();
        });


        //KASHEF ACCOUNTS == admin #email

            var adminemailBtn = document.querySelector('#kt_admin_email_copy_btn');
            var adminInputemail = document.querySelector('#kt_admin_referral_email_input');
            var adminemailClipboard = new ClipboardJS(adminemailBtn);
            adminemailClipboard.on('success', function (e) {
            var buttonAdmin = adminemailBtn.innerHTML;
            adminInputemail.classList.add('bg-success');
            adminInputemail.classList.add('text-inverse-success');
            adminemailBtn.innerHTML = 'تم النسخ!';
            setTimeout(function () {
            adminemailBtn.innerHTML = buttonAdmin;
            adminInputemail.classList.remove('bg-success');
            adminInputemail.classList.remove('text-inverse-success');
            }, 3000);  // 3seconds
            e.clearSelection();
            });

        //KASHEF ACCOUNTS == admin #PASSWORD
        var adminpasswordBtn = document.querySelector('#kt_admin_password_copy_btn');
        var adminInputpassword = document.querySelector('#kt_admin_referral_password_input');
        var adminpasswordClipboard = new ClipboardJS(adminpasswordBtn);
        adminpasswordClipboard.on('success', function (e) {
            var buttonAdmin = adminpasswordBtn.innerHTML;
            adminInputpassword.classList.add('bg-success');
            adminInputpassword.classList.add('text-inverse-success');
            adminpasswordBtn.innerHTML = 'تم النسخ!';
            setTimeout(function () {
                adminpasswordBtn.innerHTML = buttonAdmin;
                adminInputpassword.classList.remove('bg-success');
                adminInputpassword.classList.remove('text-inverse-success');
            }, 3000);  // 3seconds
            e.clearSelection();
        });
        //////////////////////////////////////Report /////////////////////////

                //KASHEF ACCOUNTS == report #Link
                var reportLinkBtn = document.querySelector('#kt_report_link_copy_btn');
                var reportInputLink = document.querySelector('#kt_report_referral_link_input');
                var reportLinkClipboard = new ClipboardJS(reportLinkBtn);
                reportLinkClipboard.on('success', function (e) {
                    var buttonreport = reportLinkBtn.innerHTML;
                    reportInputLink.classList.add('bg-success');
                    reportInputLink.classList.add('text-inverse-success');
                    reportLinkBtn.innerHTML = 'تم النسخ!';
                    setTimeout(function () {
                        reportLinkBtn.innerHTML = buttonreport;
                        reportInputLink.classList.remove('bg-success');
                        reportInputLink.classList.remove('text-inverse-success');
                    }, 3000);  // 3seconds
                    e.clearSelection();
                });
        
        
                //KASHEF ACCOUNTS == report #email
        
                    var reportemailBtn = document.querySelector('#kt_report_email_copy_btn');
                    var reportInputemail = document.querySelector('#kt_report_referral_email_input');
                    var reportemailClipboard = new ClipboardJS(reportemailBtn);
                    reportemailClipboard.on('success', function (e) {
                    var buttonreport = reportemailBtn.innerHTML;
                    reportInputemail.classList.add('bg-success');
                    reportInputemail.classList.add('text-inverse-success');
                    reportemailBtn.innerHTML = 'تم النسخ!';
                    setTimeout(function () {
                    reportemailBtn.innerHTML = buttonreport;
                    reportInputemail.classList.remove('bg-success');
                    reportInputemail.classList.remove('text-inverse-success');
                    }, 3000);  // 3seconds
                    e.clearSelection();
                    });
        
                //KASHEF ACCOUNTS == report #PASSWORD
                var reportpasswordBtn = document.querySelector('#kt_report_password_copy_btn');
                var reportInputpassword = document.querySelector('#kt_report_referral_password_input');
                var reportpasswordClipboard = new ClipboardJS(reportpasswordBtn);
                reportpasswordClipboard.on('success', function (e) {
                    var buttonreport = reportpasswordBtn.innerHTML;
                    reportInputpassword.classList.add('bg-success');
                    reportInputpassword.classList.add('text-inverse-success');
                    reportpasswordBtn.innerHTML = 'تم النسخ!';
                    setTimeout(function () {
                        reportpasswordBtn.innerHTML = buttonreport;
                        reportInputpassword.classList.remove('bg-success');
                        reportInputpassword.classList.remove('text-inverse-success');
                    }, 3000);  // 3seconds
                    e.clearSelection();
                });
 
         /////////////////////////////////////studies//////////////////////////////////////////////////////////////
        

                 //KASHEF ACCOUNTS == studies #Link
        var studiesLinkBtn = document.querySelector('#kt_studies_link_copy_btn');
        var studiesInputLink = document.querySelector('#kt_studies_referral_link_input');
        var studiesLinkClipboard = new ClipboardJS(studiesLinkBtn);
        studiesLinkClipboard.on('success', function (e) {
            var buttonstudies = studiesLinkBtn.innerHTML;
            studiesInputLink.classList.add('bg-success');
            studiesInputLink.classList.add('text-inverse-success');
            studiesLinkBtn.innerHTML = 'تم النسخ!';
            setTimeout(function () {
                studiesLinkBtn.innerHTML = buttonstudies;
                studiesInputLink.classList.remove('bg-success');
                studiesInputLink.classList.remove('text-inverse-success');
            }, 3000);  // 3seconds
            e.clearSelection();
        });


        //KASHEF ACCOUNTS == studies #email

            var studiesemailBtn = document.querySelector('#kt_studies_email_copy_btn');
            var studiesInputemail = document.querySelector('#kt_studies_referral_email_input');
            var studiesemailClipboard = new ClipboardJS(studiesemailBtn);
            studiesemailClipboard.on('success', function (e) {
            var buttonstudies = studiesemailBtn.innerHTML;
            studiesInputemail.classList.add('bg-success');
            studiesInputemail.classList.add('text-inverse-success');
            studiesemailBtn.innerHTML = 'تم النسخ!';
            setTimeout(function () {
            studiesemailBtn.innerHTML = buttonstudies;
            studiesInputemail.classList.remove('bg-success');
            studiesInputemail.classList.remove('text-inverse-success');
            }, 3000);  // 3seconds
            e.clearSelection();
            });

        //KASHEF ACCOUNTS == studies #PASSWORD
        var studiespasswordBtn = document.querySelector('#kt_studies_password_copy_btn');
        var studiesInputpassword = document.querySelector('#kt_studies_referral_password_input');
        var studiespasswordClipboard = new ClipboardJS(studiespasswordBtn);
        studiespasswordClipboard.on('success', function (e) {
            var buttonstudies = studiespasswordBtn.innerHTML;
            studiesInputpassword.classList.add('bg-success');
            studiesInputpassword.classList.add('text-inverse-success');
            studiespasswordBtn.innerHTML = 'تم النسخ!';
            setTimeout(function () {
                studiespasswordBtn.innerHTML = buttonstudies;
                studiesInputpassword.classList.remove('bg-success');
                studiesInputpassword.classList.remove('text-inverse-success');
            }, 3000);  // 3seconds
            e.clearSelection();
        });


    }

    // Public methods
    return {
        init: function () {
            initReferralProgrammClipboard();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAccountReferralsReferralProgram.init();
});

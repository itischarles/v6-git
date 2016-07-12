
$(document).ready(function ()
{
    if (sMod == 'ListClients')
    {

        var adviserLine = '<input type="checkbox" _CHECKED_ id="_ID_" value="_NAME_"></input> &nbsp; _TITLE_<br>';

        //Display list of para planners to select from ================================================================
        $('.ancAssign').click(function ()
        {
            $("#divPPList").html('Loading Advisers...');
            var oParms = {"ifaRoleCode": "AP", "firmID": '"' + sFirmID + '"', "clientUrl": '"' + $(this).prop('id') + '"'};
            $("#thisClientUrl").val($(this).prop('id'));
            $.post(
                    sBaseURL + 'getAllAdvisersForFirm',
                    oParms,
                    function (result) {

                        var sFinal = '';
                        var oAdvisers = JSON.parse(result);

                        for (var i in oAdvisers) {
                            var s = adviserLine;
                            s = s.replace('_ID_', oAdvisers[i].ifaID);
                            s = s.replace('_NAME_', oAdvisers[i].ifaName);
                            s = s.replace('_TITLE_', oAdvisers[i].ifaName);
                            s = s.replace('_CHECKED_', (oAdvisers[i].assigned === '1' ? ' checked ' : ''));

                            sFinal += s;
                        }

                        $("#divPPList").html(sFinal);

                    });

            var iTop = $(this).offset().top - 130;
            var iLeft = $(this).offset().left - 500;

            $('#divPPContainer').css({
                display: "block",
                position: "absolute",
                left: Math.ceil(iLeft) + "px",
                top: Math.ceil(iTop) + "px",
                zindex: 9999,
            });

            $('#divPPContainer').show();
            return false;

        });





        // Assign checked para planners to clients ========================================================
        $('#btnAssign').click(function ()
        {
            //var selected = [];  //alert(selected.toSource());
            var adviserIDs = '';
            $('#divPPList input:checked').each(function () {
                //selected.push($(this).attr('id'));
                adviserIDs += $(this).attr('id') + ',';
            });

            //alert(idList);
            $("#divPPList").html('Asigning Advisers...');
            var clientUrl = $("#thisClientUrl").val();

            var oParms = {"adviserIDs": '"' + adviserIDs + '"', "clientUrl": '"' + clientUrl + '"'};

            $.post(
                    sBaseURL + 'assignClientsToAdvisers',
                    oParms,
                    function (result) {
                        alert(result);
                        $('#divPPContainer').hide();

                    });

            return false;

        });//end of btnAssign Click



        // Just discard adviser selction box without doing anything===========================================
        $('#btnCancel').click(function ()
        {
            $('#divPPContainer').hide();
        });











    } else if (sMod == 'SelfRegister')
    {

        //Initialization..... 
        disableAddFirm();
        disableAddNetwork();

        $("#networkSearcher").prop('required', false);
        $("#firmSeacher").prop('required', false);

        //Open or close hidden Firm and Netowrk areas when first time loading (based on check boxes)
        if ($("#chkAddFirm").prop('checked') == true)
        {
            $("#divFirmSearchBox").show();
        }
        if ($("#chkAddNetwork").prop('checked') == true)
        {
            $("#divNetworkSearchBox").show();
        }

        //Open or colose hidden Firm / Netowrk entry areas based on previous data entry
        if ($("#hFirmID").val().trim() == '_NEW_')
        {
            $("#divFirmContainer").show();
        }
        if ($("#hNetworkID").val().trim() == '_NEW_')
        {
            $("#divNetworkContainer").show();
        }

        //<![CDATA[

        // Find firm is available or not -------------------------------
        var sControlFS = "#firmSeacher";

        $(sControlFS).autocomplete(
                {
                    source: aFirms,
                    response: function (event, ui)
                    {
                        if (!ui.content.length) {
                            var noResult = {value: "_NEW_", label: "Firm not found !, click here to add (" + $("#firmSeacher").val() + ") as a new firm."};
                            ui.content.push(noResult);
                        }
                    },
                    delay: 10,
                    autoFocus: true,
                    params: {txt: $("#firmSeacher").val()}, //Do we really need this again??
                    focus: function (event, ui)
                    {
                        event.preventDefault();
                    },
                    select: function (event, ui)
                    {
                        event.preventDefault();

                        if (ui.item.value == '_NEW_')
                        {
                            //OK we are adding a new firm ...
                            $("#hFirmID").val("_NEW_");
                            $("#divFirmContainer").show();
                            enableAddFirm();
                        } else
                        {
                            //Found an existing firm ...
                            $(sControlFS).val(ui.item.label);
                            $("#hFirmID").val(ui.item.value);
                            $("#divFirmContainer").hide();
                            disableAddFirm();


                            /* 
                             //Clarification: May be we need to disable and enable the network if we alreday got a firm and it already has the network set-up.
                             //This is to prevent user from being selecting a dirrent network than the one which is parent of the selected firm.
                             
                             if( ui.item.network_id == '' ||   ui.item.network_id == 'undefined') //No network exists with this firm....
                             {
                             enableAddNetwork();
                             }
                             else // OK we have a valid network id here. Load the network
                             {
                             disableAddNetwork();
                             $("#hFirmID").val(ui.item.value);
                             }
                             */

                        }
                    }
                });

        // Find Network is available or not -------------------------------
        var sControlNS = "#networkSearcher";

        $(sControlNS).autocomplete(
                {
                    source: aNetworks,
                    response: function (event, ui)
                    {
                        if (!ui.content.length)
                        {
                            var noResult = {value: "_NEW_", label: "Network not found !, click here to add (" + $("#networkSeacher").val() + ") as a new network."};
                            ui.content.push(noResult);
                        }
                    },
                    delay: 0,
                    autoFocus: true,
                    params: {txt: $(sControlNS).val()},
                    focus: function (event, ui)
                    {
                        event.preventDefault();
                  },
                    select: function (event, ui)
                    {
                        event.preventDefault();
                        if (ui.item.value == '_NEW_')
                        {
                            $("#hNetworkID").val('_NEW_');
                            $("#divNetworkContainer").show();
                            enableAddNetwork();

                        } else
                        {
                            $(sControlNS).val(ui.item.label);
                            $("#hNetworkID").val(ui.item.value);
                            $("#divNetworkContainer").hide();
                            disableAddNetwork();
                        }

                    }
                });


        // Add Firm Checkbox event ------------------------------------
        $('#chkAddFirm').change(function ()
        {
            if ($(this).is(":checked"))
            {
                $("#divFirmSearchBox").show();
                $("#firmSeacher").prop('required', true);

                if ($("#hFirmID").val() == '_NEW_')
                {
                    $("#divFirmContainer").show();
                    enableAddFirm();
                } else
                {
                    disableAddFirm();
                }
            } else
            {
                $("#hFirmID").val('')
                $("#divFirmSearchBox").hide();
                $("#divFirmContainer").hide();
                $("#firmSeacher").prop('required', false);
                disableAddFirm();
            }
        });


        // Add Network Checkbox event ------------------------------------
        $('#chkAddNetwork').change(function ()
        {
            if ($(this).is(":checked"))
            {
                $("#divNetworkSearchBox").show();
                $("#networkSearcher").prop('required', true);

                if ($("#hNetworkID").val() == '_NEW_')
                {
                    $("#divNetworkContainer").show();
                    enableAddNetwork();
                } else
                {
                    disableAddNetwork();
                }
            } else
            {
                $("#hNetworkID").val('')
                $("#divNetworkSearchBox").hide();
                $("#divNetworkContainer").hide();
                $("#networkSearcher").prop('required', false);
                disableAddNetwork();
            }
        });


        //Enable and Disable required fields for Network -------------------

        function enableAddNetwork()
        {
            $("#networkFCANo").prop('required', true);
            $("#networkAddress1").prop('required', true);
            $("#networkPostalCode").prop('required', true);
            $("#networkCity").prop('required', true);
            $("#networkEmail").prop('required', true);
            $("#networkTelephone").prop('required', true);
            $("#networkContact").prop('required', true);
        }
        function disableAddNetwork()
        {
            $("#networkFCANo").prop('required', false);
            $("#networkAddress1").prop('required', false);
            $("#networkPostalCode").prop('required', false);
            $("#networkCity").prop('required', false);
            $("#networkEmail").prop('required', false);
            $("#networkTelephone").prop('required', false);
            $("#networkContact").prop('required', false);
        }

        //Enable and Disable required fields for Firm -------------------

        function enableAddFirm()
        {
            $("#firmFCANo").prop('required', true);
            $("#firmAddress1").prop('required', true);
            $("#firmPostalCode").prop('required', true);
            $("#firmCity").prop('required', true);
            $("#firmEmail").prop('required', true);
            $("#firmTelephone").prop('required', true);
            $("#firmContact").prop('required', true);
        }
        function disableAddFirm()
        {
            $("#firmFCANo").prop('required', false);
            $("#firmAddress1").prop('required', false);
            $("#firmPostalCode").prop('required', false);
            $("#firmCity").prop('required', false);
            $("#firmEmail").prop('required', false);
            $("#firmTelephone").prop('required', false);
            $("#firmContact").prop('required', false);
        }


//]]>

    }

}); //end document ready
jQuery(document).ready(function($) {
	// Apply for a job
    var applyBtn = $(".job-apply-submit")
    var jobApplyForm = $(".job-apply-form")
    jobApplyForm.on("submit", function(e) {
        e.preventDefault()

        if (!$(".job-apply-submit + .loading").length) {
        	applyBtn.after('<span class="loading ml-2 ms-2" style="height: 30px; display: inline-block; padding: 4px; box-sizing: border-box;"><img 30px" src="'+wp_obj.admin_images+'/spinner.gif"></span>')
        }

        var formData = Object.fromEntries(new FormData(e.target).entries())

        if (formData.hasOwnProperty("resume")) {
            var reader  = new FileReader()
            var file    = formData["resume"]
            reader.onload = function(e) {
                // binary data
                formData["resume"] = e.target.result
            }
            reader.onerror = function(e) {
                // error occurred
                console.log('Error : ' + e.type)
            }
            reader.readAsBinaryString(file)
        }

        if (formData.hasOwnProperty("cover-letter")) {
            var reader  = new FileReader()
            var file    = formData["cover-letter"]
            reader.onload = function(e) {
                // binary data
                formData["cover-letter"] = e.target.result
            }
            reader.onerror = function(e) {
                // error occurred
                console.log('Error : ' + e.type)
            }
            reader.readAsBinaryString(file)
        }

        $.ajax({
        	type: "post",
            dataType: "json",
            url: wp_obj.ajax_url,
            data: {
            	action: "jobadder_api_apply_for_job",
                data: formData
            },
            success: (res) => {
                var messageElement = jobApplyForm.find(".form-message")

                if (res.success) {
                    messageElement.addClass("text-success")
                    messageElement.html("Application submitted!")
                } else {
                    messageElement.addClass("text-danger")
                    jobApplyForm.find(".form-message").html(res.data.message)
                }

                if ($(".job-apply-submit + .loading").length) {
                    $(".job-apply-submit + .loading").remove()
                }
            },
            error: (err) => {
            	console.log(err)
            }
        })
    })
})

function jobCoverTypeCheck(that, jobId) {
    if (that.value == "cover-letter") {
        document.getElementById("cover-letter-"+jobId).parentNode.style.display = "block";
    } else {
        document.getElementById("cover-letter-"+jobId).parentNode.style.display = "none";
    }

    if (that.value == "cover-note") {
        document.getElementById("cover-note-"+jobId).parentNode.style.display = "block";
    } else {
        document.getElementById("cover-note-"+jobId).parentNode.style.display = "none";
    }
}
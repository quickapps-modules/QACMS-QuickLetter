
/* This is an example of how to cancel all the files queued up.  It's made somewhat generic.  Just pass your SWFUpload
object in to this method and it loops through cancelling the uploads. */
function cancelQueue(instance) {
	document.getElementById(instance.customSettings.cancelButtonId).disabled = true;
	instance.stopUpload();
	var stats;
	
	do {
		stats = instance.getStats();
		instance.cancelUpload();
	} while (stats.files_queued !== 0);
	
}

/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
function fileDialogStart() {
	/* I don't need to do anything here */
}
function fileQueued(file) {
	try {
		// You might include code here that prevents the form from being submitted while the upload is in
		// progress.  Then you'll want to put code in the Queue Complete handler to "unblock" the form
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus(__("Pending..."));
		progress.toggleCancel(true, this);

	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert(__("You have attempted to queue too many files.\n") + (message === 0 ? __("You have reached the upload limit.") : __("You may select ") + (message > 1 ? __("up to ") + message + __(" files.") : __("one file."))));
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus(__("File is too big."));
			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus(__("Cannot upload Zero Byte files."));
			this.debug(__("Error Code: Zero byte file, File name: ") + file.name + __(", File size: ") + file.size + __(", Message: ") + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			progress.setStatus("Invalid File Type.");
			this.debug(__("Error Code: Invalid File Type, File name: ") + file.name + __(", File size: ") + file.size + __(", Message: ") + message);
			break;
		case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
			alert(__("You have selected too many files.  ") +  (message > 1 ? __("You may only add ") +  message + __(" more files") : __("You cannot add any more files.")));
			break;
		default:
			if (file !== null) {
				progress.setStatus(__("Unhandled Error"));
			}
			this.debug(__("Error Code: ") + errorCode + __(", File name: ") + file.name + __(", File size: ") + file.size + __(", Message: ") + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (this.getStats().files_queued > 0) {
			document.getElementById(this.customSettings.cancelButtonId).disabled = false;
		}
		
		/* I want auto start and I can do that here */
		this.startUpload();
	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and return true to indicate that the upload should start */
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus(__("Uploading..."));
		progress.toggleCancel(true, this);
	}
	catch (ex) {
	}
	
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {

	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		//Messaging.pingProgress(percent);
		//window.setTimeout(on_progress, 500);

		progress.setStatus(__("Uploading..."));
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus(__("Complete..."));
		progress.toggleCancel(false);

	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file) {
	try {
		/*  I want the next upload to continue automatically so I'll call startUpload here */
		if (this.getStats().files_queued === 0) {
			document.getElementById(this.customSettings.cancelButtonId).disabled = true;
		} else {	
			this.startUpload();
		}
	} catch (ex) {
		this.debug(ex);
	}

}

function uploadError(file, errorCode, message) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus(__("Upload Error: ") + message);
			this.debug(__("Error Code: HTTP Error, File name: ") + file.name + __(", Message: ") + message);
			break;
		case SWFUpload.UPLOAD_ERROR.MISSING_UPLOAD_URL:
			progress.setStatus(__("Configuration Error"));
			this.debug(__("Error Code: No backend file, File name: ") + file.name + __(", Message: ") + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus(__("Upload Failed."));
			this.debug(__("Error Code: Upload Failed, File name: ") + file.name + __(", File size: ") + file.size + __(", Message: ") + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("Server (IO) Error");
			this.debug(__("Error Code: IO Error, File name: ") + file.name + __(", Message: ") + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus(__("Security Error"));
			this.debug(__("Error Code: Security Error, File name: ") + file.name + __(", Message: ") + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			progress.setStatus("Upload limit exceeded.");
			this.debug(__("Error Code: Upload Limit Exceeded, File name: ") + file.name + __(", File size: ") + file.size + __(", Message: ") + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SPECIFIED_FILE_ID_NOT_FOUND:
			progress.setStatus(__("File not found."));
			this.debug(__("Error Code: The file was not found, File name: ") + file.name + __(", File size: ") + file.size + __(", Message: ") + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			progress.setStatus(__("Failed Validation.  Upload skipped."));
			this.debug(__("Error Code: File Validation Failed, File name: ") + file.name + __(", File size: ") + file.size + __(", Message: ") + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			progress.setStatus(__("Cancelled"));
			progress.setCancelled();
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			progress.setStatus(__("Stopped"));
			break;
		default:
			progress.setStatus(__("Unhandled Error: ") + error_code);
			this.debug(__("Error Code: ") + errorCode + __(", File name: ") + file.name + __(", File size: ") + file.size + __(", Message: ") + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}
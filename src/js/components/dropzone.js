const FileUploadInit = () => {
	class FileUpload {
		constructor(el) {
			this.el = el;
			// this.el.style.backgroundColor = "red";
			this.inputElement = this.el.querySelector("input[type=file]");
			this.existingImage = this.el.querySelector(".show-if-value img");
            this.inputElement.addEventListener('change', this.previewPhoto);
		}

        previewPhoto = () => {
            const file = this.inputElement.files;
            console.log("preview photo")
            console.log(file);
            if (file) {
                const fileReader = new FileReader();
                // const preview = document.querySelector('show-if-value image-wrap');
                fileReader.onload = event => {
                    this.existingImage.setAttribute('src', event.target.result);
                    this.el.classList.add("has-value");
                }
                fileReader.readAsDataURL(file[0]);
            }
        }

		emptyUpload() {
			

		}
	}

    const AddGalleryRow = document.querySelector(".acf-repeater-add-row");
    if(AddGalleryRow){
        AddGalleryRow.addEventListener("click", function (e) {
            console.log("Add instance");
            var Parent = e.currentTarget.parentNode.parentNode;
            var NewTrRows = Parent.querySelectorAll(".acf-row");
            console.log(NewTrRows.length);
            if (NewTrRows.length) {
                setTimeout(function(){
                    console.log(NewTrRows[NewTrRows.length - 1]);
                    console.log(NewTrRows[NewTrRows.length - 1].previousSibling);
                    var NewFileUploader = NewTrRows[NewTrRows.length - 1].previousSibling.querySelector(".acf-image-uploader");
                    console.log(NewFileUploader);
                    new FileUpload(NewFileUploader)
                }, 100);
            }
        });
    }

	const FileUploaders = document.querySelectorAll(".acf-image-uploader");
	
	if (FileUploaders.length) {
		[...FileUploaders].map((FileUploader) => new FileUpload(FileUploader));
	}
}

export default FileUploadInit;

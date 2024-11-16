import * as filePond from "filepond";
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';
// import FilePondPluginImageEdit from 'filepond-plugin-image-edit';
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginFileEncode from 'filepond-plugin-file-encode';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';

import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import 'filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css';


const FilePond = () => {
	class FileUpload {
		constructor(el) {
			this.el = el;
			this.acf_gallery_main = this.el.querySelector(".acf-gallery-main");
			this.acf_gallery_side = this.el.querySelector(".acf-gallery-side");
			this.acf_gallery_attachments = this.el.querySelectorAll(".acf-gallery-attachment");
			
			this.inputElement = this.el.querySelector("input[type='file']");
			this.existingImage = this.el.querySelector(".show-if-value img");
			this.adminAjaxUrl = document.querySelector('.main').getAttribute('data-admin-ajax');

			this.mainDiv = document.createElement('div');
			this.mainDiv.id = "acf-field_668bebd5183ae";
			this.mainDiv.setAttribute("data-nonce", "fdd1a1994a");
			// this.parentDiv = document.createElement('div');
			// this.parentDiv.className = "af-field af-field-type-gallery af-field-user-gallery-filepond acf-field acf-field-gallery acf-field-668bebd5183ae";
			// this.parentDiv.setAttribute("data-name", "user_gallery_filepond");
			// this.parentDiv.setAttribute("data-key", "field_668bebd5183ae");
			// this.parentDiv.appendChild(this.mainDiv);
			this.el.parentNode.appendChild(this.mainDiv);




			console.log(this.el);
			console.log(this.inputElement);

			filePond.registerPlugin(
				FilePondPluginImagePreview,
				FilePondPluginImageCrop,
				FilePondPluginFileEncode,
			);

			const existingImages = this.getExistingImages();

			this.createFilePondInput(existingImages);
			this.acf_gallery_main.style.display = "none";
			this.acf_gallery_side.style.display = "none";
			this.el.remove();

			this.mainDiv.style.height = "auto";
		}
		createFilePondInput(existingImages) {
			// Create the input element
			const inputElement = document.createElement('input');
			const inputElementAttachments = document.createElement('input');
			inputElement.type = 'file';
			inputElement.className = 'filepond';
			inputElement.name = 'acf[field_668bebd5183ae][]';
			inputElement.multiple = true;
			inputElementAttachments.type = 'hidden';
			inputElementAttachments.className = 'filepond_attachment_ids';
			inputElementAttachments.value = "";
	  
			// Append the input element to the container
			this.mainDiv.appendChild(inputElement);
			this.mainDiv.appendChild(inputElementAttachments);
	  
			// Create a FilePond instance
			const pond = filePond.create(inputElement, {
				allowImageCrop: true,
			});
	  
			// Prepopulate with existing images if provided
			if (existingImages && existingImages.length > 0) {
			  existingImages.forEach(image => {
				pond.addFile(image.source, image.options);
			  });
			}
	  
			return pond;
		}
		getExistingImages() {
			const images = this.el.querySelectorAll('.acf-gallery-attachment img');
			return Array.from(images).map(img => ({
			  source: img.src,
			  options: { type: 'remote' }
			}));
		}
	}


	document.addEventListener('FilePond:loaded', (e) => {
		console.log('FilePond ready for use', e.detail);
	});

	document.addEventListener('FilePond:pluginloaded', (e) => {
		console.log('FilePond plugin is ready for use', e.detail);
	});
	
    // const AddGalleryRow = document.querySelector(".acf-repeater-add-row");
	// console.log(AddGalleryRow);
	// AddGalleryRow.addEventListener("click", function (e) {
	// 	console.log("Add filepond instance");
	// 	var Parent = e.currentTarget.parentNode.parentNode;
	// 	var NewFileUploaders = Parent.querySelectorAll(".acf-image-uploader");
	// 	if (NewFileUploaders.length) {
	// 		console.log(NewFileUploaders[NewFileUploaders.length - 1]);
	// 		console.log(NewFileUploaders.length - 1);
	// 		[...NewFileUploaders].map((NewFileUploader) => new FileUpload(NewFileUploader));
	// 	}
	// });


	const FileUploaders = document.querySelectorAll(".acf-gallery");
	
	if (FileUploaders.length) {
		[...FileUploaders].map((FileUploader) => new FileUpload(FileUploader));
	}
}

export default FilePond;

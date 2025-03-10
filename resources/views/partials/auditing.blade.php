<div>
    @if ($isAudit)
    <div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400"  x-show="open" x-transition x-cloak style="display: none !important">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-100 dark:bg-gray-900 opacity-50"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​

            <div class=" px-4 py-6 inline-block align-bottom h-[650px] over  rounded-sm bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full " role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class=" overflow-y-auto">
                    <div class="flex mb-4">
                        <div class="sm:w-8/12 w-full">
                            <a class="text-xl">{{$alertId}} - {{$analis}}</a>
                        </div>
                    </div>
                    <label class="w-full"  >
                        <div class="relative flex w-full flex-col  text-neutral-600 dark:text-neutral-300">
                            <label for="os" class="w-fit pl-0.5 text-gray-700 mb-1 text-sm">Alert Status</label>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-9 size-5">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                            <select wire:ignore wire:model='alertStatus' class="w-full appearance-none  border border-neutral-300 bg-gray-100 px-4 py-2 text-sm focus:outline-none">
                                <option selected>Pending</option>
                                <option value="rejected">Rejected</option>
                                <option value="revision">Revision</option>
                                <option value="duplicate">duplicate</option>
                                <option value="approved">Approved</option>
                                <option value="reexportimage">Re-export planet images</option>
                                <option value="reclassification">Re-classification</option>

                            </select>
                        </div>
                    </label>

                    <div class="w-full  border-gray-300  mb-6 mt-6">
                        <h1 class="text-gray-700 ">Reason</h1>
                        <div class="w-full  border-transparent focus:border-transparent focus:ring-0 "
                            wire:ignore
                            x-init="
                            tinymce.init({
                                selector: '#alertReason',
                                height : '30vh',
                                relative_urls : false,
                                    remove_script_host : false,
                                    convert_urls : true,
                                    highlight_on_focus: false,
                                    content_style: 'body {  background-color: #f4f5f7; font-size: 14px; }, ',
                                    plugins:
                                        'lists advlist autolink  link image  charmap    anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking table emoticons template  help',

                                        toolbar: ' fullscreen image  bullist numlist   | ',
                                        menu: {
                                        favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
                                        },
                                        menubar: ' ',
                                        file_picker_callback : function(callback, value, meta) {
                                            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                                            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
                                            var cmsURL = '/cms/' + 'controlsheet-filemanager?editor=' + meta.fieldname;
                                            if (meta.filetype == 'image') {
                                                cmsURL = cmsURL + '&type=Images';
                                            } else {
                                                cmsURL = cmsURL + '&type=Files';
                                            }
                                            tinyMCE.activeEditor.windowManager.openUrl({
                                                url : cmsURL,
                                                title : 'Filemanager',
                                                width : x * 0.8,
                                                height : y * 0.8,
                                                resizable : 'yes',
                                                close_previous : 'no',
                                                onMessage: (api, message) => {
                                                callback(message.content);
                                                }
                                            });
                                        },
                                        setup: function(editor) {
                                            editor.on('change', function(e) {
                                                @this.set('alertReason', editor.getContent());
                                        });
                                    }
                            });">
                            <textarea  rows="1" id="alertReason" name="alertReason"  wire:model.defer='alertReason' required></textarea>
                        </div>
                    </div>

                </div>



                <div class=" px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-6 mb-6 bottom-0 right-0 fixed">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:loading.remove wire:click="auditing({{ $alertId }})" type="button" class=" cursor-pointer inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-black text-base leading-6 font-medium text-gray-200 dark shadow-sm  focus:outline-none  transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Audit Alert
                        </button>

                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                        <button wire:loading.remove wire:click='closeReason' type="button" class=" cursor-pointer inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Close
                        </button>

                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif
<script>
    // Prevent bootstrap dialog from blocking focusin
        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".alertReason").length) {
                e.stopImmediatePropagation();
            }
        });

</script>
</div>

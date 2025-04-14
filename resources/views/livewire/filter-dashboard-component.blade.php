<div class="px-4 py-4 border-gray-100 border mb-4">
    <a class="text-sm">Filter</a>
    <div class="flex gap-4 mt-2">
        <div class="sm:w-36 w-full relative flex  flex-col  text-neutral-600 dark:text-neutral-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-2 size-5">
                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
            <select wire:ignore id='date-dropdown' wire:model="yearAlert" class=" w-full appearance-none text-black  border border-neutral-300 bg-gray-100 px-4 py-2 text-sm focus:outline-none">

            </select>
        </div>
        <button wire:click='filter' class="bg-black py-2 px-4 text-white sm:w-32 w-full cursor-pointer h-10">
            Submit
        </button>
    </div>
    <script>
        let dateDropdown = document.getElementById('date-dropdown');

        let currentYear = new Date().getFullYear();
        let earliestYear = 2020;
        while (currentYear >= earliestYear) {
            let dateOption = document.createElement('option');
            dateOption.text = currentYear;
            dateOption.value = currentYear;
            dateDropdown.add(dateOption);
            currentYear -= 1;
        }

    </script>
</div>

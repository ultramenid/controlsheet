<div class="py-6 px-4 border border-gray-100 z-20 relative  bg-white mt-12">
    <div class="text-sm mb-6">
        <a>Alert by validator</a>
        <div class="mt-2">
            <input class="sm:w-52 w-full py-1 border-gray-500 border px-2 focus:outline-none text-xs" wire:model.live='searchName' placeholder="validator name">
        </div>
    </div>

    <div class="overflow-y-auto w-full">
        <table class="w-full border-collapse border-b border-gray-300">
          <thead class="text-xs font-semibold">
            <tr class="bg-gray-50 text-left">
              <th class=" cursor-pointer border-b border-gray-300 px-4 py-2">Validator</th>
              <th class="border-b border-gray-300 px-4 py-2">Aprroved</th>
              <th class="border-b border-gray-300 px-4 py-2">Rejected</th>
              <th class="border-b border-gray-300 px-4 py-2">Duplicate</th>
              <th class="border-b border-gray-300 px-4 py-2">Pending</th>
              <th class="border-b border-gray-300 px-4 py-2">TOTAL</th>
            </tr>
          </thead>
          <tbody class="text-xs">
            @foreach ($alerts as $item )
                <tr class="border-t">
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->name}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->approved}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->rejected}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->duplicate}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->pending}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->total}}</td>
                </tr>
            @endforeach


          </tbody>
        </table>
      </div>



</div>

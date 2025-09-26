<div class="py-6 px-4 border border-gray-100 z-20 relative  bg-white mt-4">
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
              <th wire:click='sortingField("name")' class=" cursor-pointer border-b border-gray-300 px-4 py-2">Validator</th>
              <th wire:click='sortingField("approved")' class="cursor-pointer border-b border-gray-300 px-4 py-2">Aprroved</th>
              <th wire:click='sortingField("reexportimage")' class="cursor-pointer border-b border-gray-300 px-4 py-2">reexportimage</th>
              <th wire:click='sortingField("reclassification")' class="cursor-pointer border-b border-gray-300 px-4 py-2">reclassification</th>
              <th wire:click='sortingField("rejected")' class="cursor-pointer border-b border-gray-300 px-4 py-2">Rejected</th>
              <th wire:click='sortingField("duplicate")' class="cursor-pointer border-b border-gray-300 px-4 py-2">Duplicate</th>
              <th wire:click='sortingField("pending")' class="cursor-pointer border-b border-gray-300 px-4 py-2">Pending</th>
              <th class="cursor-pointer border-b border-gray-300 px-4 py-2">Sccon</th>
              <th class="cursor-pointer border-b border-gray-300 px-4 py-2">Workspace</th>
              <th wire:click='sortingField("total")' class="cursor-pointer border-b border-gray-300 px-4 py-2">TOTAL</th>
            </tr>
          </thead>
          <tbody class="text-xs">
            @forelse ($alerts as $item )
                <tr class="border-t hover:bg-gray-50">
                    <td class=" border-b border-gray-300 px-4 py-2"><a href="{{ url('/alertanalis/'.$item->userId) }}" class="hover:underline">{{$item->name}}</a></td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->approved}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->reexportimage}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->reclassification}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->rejected}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->duplicate}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->pending}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->sccon}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->workspace}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2">{{$item->total}}</td>
                </tr>
                @empty
                <tr>
                    <td class=" border-b border-gray-300 px-4 py-2">No data found</td>
                </tr>
            @endforelse


          </tbody>
        </table>
      </div>

      {{-- @if ($alerts)
      {{ $alerts->links('livewire.pagination') }}
      @endif --}}

</div>

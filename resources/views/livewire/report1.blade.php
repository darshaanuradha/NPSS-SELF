<div class="">

    <div class="mx-auto max-w-max sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-slate-500">

            <div wire:loading.block class="flex justify-center w-full h-full p-2 text-center bg-black opacity-60"
                style="position:fixed; top:0; left:0"></div>
            <div id = "loading_indicator">
                <div class="text-center">
                    <div role="status">
                        <svg aria-hidden="true" class="inline w-8 h-8 mr-2 text-gray-200 animate-spin fill-green-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>






            <div class="p-2 form-group row ">
                <label for="state" class="col-md-4 col-form-label text-md-right"></label>




                <div class="col-md-6">

                    <div class="grid grid-cols-4 gap-4">
                        <div><label for="state" class="text-black col-md-4 col-form-label text-md-right">From
                                Date</label></div>
                        <div><input type="date" wire:loading.attr="disabled" wire:model.debounce.300ms="fromdate"
                                wire:model.lazy="fromdate" class="w-full " value=""></div>
                        <div><label for="state" class="text-black col-md-4 col-form-label text-md-right">To
                                Date</label></div>
                        <div><input type="date" wire:loading.attr="disabled" wire:model.debounce.300ms="todate"
                                wire:model.lazy="todate" class="w-full border-gray-900 " value=""></div>
                    </div>


                    <div>

                        <div class ="grid grid-cols-4 p-1 border-gray-900">
                            <label for="state" class="w-3 text-black col-md-4 col-form-label text-md-right">Select
                                Report Type</label>
                            <select wire:model.lazy="selectedrange" class="w-full text-green-900 border form-control "
                                wire:loading.attr="disabled">
                                <option value="1" selected>District wise</option>
                                <option value="2" selected>ASC wise</option>
                                <option value="3" selected>AI Range wise</option>
                            </select>
                        </div>


                    </div>

                    <div class ="grid grid-cols-4 p-1 border-gray-900">
                        <label for="state" class="w-3 text-black col-md-4 col-form-label text-md-right">Select
                            District</label>
                        <select wire:model.lazy="selecteddistrict" class="w-full text-green-900 border form-control "
                            wire:change="clear1()" wire:loading.attr="disabled">
                            <option value="" selected>Select District</option>
                            @foreach ($dis as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class ="grid grid-cols-4 p-1 border-gray-900">
                        <label for="state" class="w-3 text-black col-md-4 col-form-label text-md-right">Select
                            ASC</label>
                        <select wire:model.lazy="selectedasc" class="w-full text-green-900 border-gray-900 form-control"
                            wire:change="clear2()" wire:loading.attr="disabled">
                            <option value="" selected>Select ASC</option>
                            @foreach ($asc as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>




                    <div id="a" class="hidden">
                        <select id="test1" wire:model.lazy="selectedgs"
                            class="w-full text-green-900 border-gray-900 form-control" wire:change="" onchange=""
                            wire:loading.attr="disabled">
                            <option value="" selected>Select AI Range</option>
                            @foreach ($airange as $item)
                                <option value="">{{ $item->ai_range }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!--<x-button class="bg-sky-800 hover:bg-sky-700" wire:click="showdata({{ $this->selectedgs }})">Show</x-button>-->
            <label for="state" class="col-md-4 col-form-label text-md-right"></label>


            @if ($selrange == 3)
                <table class="w-full divide-y divide-sky-700">

                    <thead class="text-gray-200 bg-sky-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-black whitespace-nowrap">AI Range</th>
                            <th scope="col" class="px-6 py-4 text-black whitespace-nowrap">ASC</th>
                            <th scope="col" class="w-4 px-6 py-4 text-black whitespace-nowrap">District</th>

                            <th scope="col" class="px-6 py-3 text-black ">Thrips</th>
                            <th scope="col" class="px-6 py-3 text-black ">Gall Midge</th>
                            <th scope="col" class="px-6 py-3 text-black ">Leaffolder</th>
                            <th scope="col" class="px-6 py-3 text-black ">Yellow Stem Borer</th>
                            <th scope="col" class="px-6 py-3 text-black ">BPH</th>
                            <th scope="col" class="px-6 py-3 text-black ">Paddy bugs</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-sky-500">
                        @foreach ($alldata as $item)
                            <tr>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->district }} </td>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->ascenter }} </td>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->ai }} </td>

                                @if ($item->reccount != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->thrips / $item->reccount, 2, '.', ',') }}</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 25)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 3)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->reccount != 0 && $item->reccount != 0)
                                    @if ($item->bhp / $item->reccount / 50 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 2)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @endif

                                @if ($item->reccount != 0 && $item->reccount != 0)
                                    @if ($item->paddybug / $item->reccount / 10 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 4)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 15)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif


            @if ($selrange == 2)
                <table class="w-full divide-y divide-sky-700">

                    <thead class="text-gray-200 bg-sky-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-black whitespace-nowrap">ASC</th>
                            <th scope="col" class="w-4 px-6 py-4 text-black whitespace-nowrap">District</th>


                            <th scope="col" class="px-6 py-3 text-black ">Thrips</th>
                            <th scope="col" class="px-6 py-3 text-black ">Gall Midge</th>
                            <th scope="col" class="px-6 py-3 text-black ">Leaffolder</th>
                            <th scope="col" class="px-6 py-3 text-black ">Yellow Stem Borer</th>
                            <th scope="col" class="px-6 py-3 text-black ">BPH</th>
                            <th scope="col" class="px-6 py-3 text-black ">Paddy bugs</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-sky-500">
                        @foreach ($alldataasc as $item)
                            <tr>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->ascenter }} </td>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->district }} </td>


                                @if ($item->reccount != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->thrips / $item->reccount, 2, '.', ',') }}-{{ $item->thrips }}-{{ $item->reccount }}
                                    </td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 25)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 3)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap"></td>9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->reccount != 0)
                                    @if ($item->bhp / $item->reccount / 50 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 2)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @endif

                                @if ($item->reccount != 0)
                                    @if ($item->paddybug / $item->reccount / 10 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 4)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 15)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif



            @if ($selrange == 1)
                <table class="w-full divide-y divide-sky-700">

                    <thead class="text-gray-200 bg-sky-600">
                        <tr>
                            <th scope="col" class="w-4 px-6 py-4 text-black whitespace-nowrap">District</th>

                            <th scope="col" class="px-6 py-3 text-black ">Thrips</th>
                            <th scope="col" class="px-6 py-3 text-black ">Gall Midge</th>
                            <th scope="col" class="px-6 py-3 text-black ">Leaffolder</th>
                            <th scope="col" class="px-6 py-3 text-black ">Yellow Stem Borer</th>
                            <th scope="col" class="px-6 py-3 text-black ">BPH</th>
                            <th scope="col" class="px-6 py-3 text-black ">Paddy bugs</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-sky-500">
                        @foreach ($alldatadis as $item)
                            <tr>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->district }} </td>

                                @if ($item->reccount != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->thrips / $item->reccount, 2, '.', ',') }}</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 25)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 3)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->bhp / $item->reccount / 50 == 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 2)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 5)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 10)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 20)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                @endif


                                @if ($item->paddybug / $item->reccount / 10 == 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 1)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 4)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 15)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 20)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif



        </div>
    </div>
</div>







<script>
    document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            document.querySelector("body").style.visibility = "hidden";
            document.getElementById("loading_indicator").style.visibility = "visible";
        } else {

            document.getElementById("loading_indicator").style.display = "none";
            document.querySelector("body").style.visibility = "visible";

        }
    };
</script>



<style>
    #loading_indicator {

        visibility: hidden;
    }


    @keyframes spinIndicator {
        100% {
            transform: rotate(360deg);
        }
    }
</style>

@extends('layouts.app')

@section('nav')
    @parent
@endsection

@section('content')
    <div class="md:w-1/2 sm:w-full sm:mx-auto md:mx-auto">
        <div class="">
            <div class="font-medium text-lg text-indigo-700 bg-brand px-3 py-2 rounded-t">
                @if($practise){{ $practise->date_of_practise->subMinutes(30)->format('d.m.Y H:i') }} Uhr @endif
                <h2>Aktuell wird OPEN AIR am Meiningser Weg gespielt.</h2>
                @if($practise)<h3 class="mb-2 font-medium mt-2 text-2xl">Aktuelle Teilnehmerzahl: {{ $practise->participators->count() }}</h3> @endif
            </div>

            @if($birthdays->count() > 0)
                <div class="rounded-md bg-yellow-50 py-2">
                    <div class="flex">
                        <div class="flex-shrink-0">

                            <svg class="h-12 w-12 text-yellow-400"
                                                         viewBox="0 0 432 432" style="enable-background:new 0 0 432 432;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:#B0444D;}
                            .st1{fill:#C1292E;}
                            .st2{fill:#020203;}
                            .st3{fill:#F39323;}
                            .st4{fill:#1B1B1B;}
                            .st5{fill:#8EC045;}
                            .st6{fill:#2DABE3;}
                            .st7{fill:#DEBF80;}
                            .st8{fill:#CD9C61;}
                            .st9{fill:#F9B03D;}
                            .st10{fill:#009245;}
                            .st11{fill:#DC93AB;}
                            .st12{fill:#BAC4AA;}
                            .st13{fill:#BEBDBE;}
                            .st14{fill:#BDB0A3;}
                            .st15{fill:#768DAF;}
                            .st16{fill:#6FA1BD;}
                            .st17{fill:#C0C0BF;}
                            .st18{fill:#93B75A;}
                            .st19{fill:#C88C5E;}
                            .st20{fill:#BA9BC9;}
                            .st21{fill:#6BC4CD;}
                            .st22{fill:#828BC5;}
                            .st23{fill:#E2A85A;}
                            .st24{fill:#EAB063;}
                            .st25{fill:#C53C46;}
                            .st26{fill:#E56D48;}
                            .st27{fill:#5BB063;}
                            .st28{fill:#F3977C;}
                            .st29{fill:#1C907F;}
                            .st30{fill:#B190C2;}
                            .st31{fill:#C1944E;}
                            .st32{fill:#F4A08D;}
                            .st33{fill:#C17A3B;}
                            .st34{fill:#C1906B;}
                            .st35{fill:#BC373C;}
                            .st36{fill:#DD7629;}
                            .st37{fill:#A982B9;}
                            .st38{fill:#343434;}
                            .st39{fill:#EE7DAF;}
                            .st40{fill:#B0D49A;}
                            .st41{fill:#FED47A;}
                            .st42{fill:#47AC6C;}
                            .st43{fill:#FCC02D;}
                            .st44{fill:#F28D36;}
                            .st45{fill:#3BB0D7;}
                            .st46{fill:#F18FA9;}
                            .st47{fill:#E497AC;}
                            .st48{fill:#F9D0DD;}
                            .st49{fill:#FCC44A;}
                            .st50{fill:#9F4E53;}
                            .st51{fill:#EFC14F;}
                            .st52{fill:#E2934E;}
                            .st53{fill:#CDCCCC;}
                            .st54{fill:#00A2B3;}
                            .st55{fill:#EE751B;}
                            .st56{fill:#CD242A;}
                            .st57{fill:#48A6A0;}
                            .st58{fill:#544842;}
                            .st59{fill:#7CB5A8;}
                            .st60{fill:#4E8896;}
                            .st61{fill:#CC91AC;}
                            .st62{fill:#57A272;}
                            .st63{fill:#67A2B5;}
                            .st64{fill:#C98D30;}
                            .st65{fill:#D34B4B;}
                            .st66{fill:#D98181;}
                            .st67{fill:#947552;}
                            .st68{fill:#521B29;}
                            .st69{fill:#7B4754;}
                            .st70{fill:#B29F8B;}
                            .st71{fill:#F1B672;}
                            .st72{fill:#A37C4D;}
                            .st73{fill:#7392A0;}
                            .st74{fill:#8C4044;}
                            .st75{fill:#A97779;}
                            .st76{fill:#A58594;}
                            .st77{fill:#60314A;}
                            .st78{fill:#944C71;}
                        </style>
                                <g>
                                    <g>
                                        <path class="st54" d="M371.2,252.9c-0.7,0.3-1.3,0.6-1.9,0.9c-1.1,0.4-2.3,0.7-3.4,1.2c-2,0.9-3.8,0.5-5.6-0.3
			c-2.5-1.1-4.1-3-5.4-5.3c-1-1.8-1.6-3.7-2-5.6c-0.4-2.1-0.8-4.1-1.2-6.2c-1.7-7.9-6.9-12.1-14.6-13.5c-1.9-0.3-3.9-0.4-5.8-0.7
			c-0.9-0.1-1.8-0.3-2.7-0.6c-2.3-0.7-4-2.2-5-4.4c-1-1.9-1.4-4.1-1.7-6.2c-0.3-2-0.5-4.1-0.9-6.1c-0.7-3.8-2.2-7.3-4.8-10.2
			c-2.6-3-5.7-5-9.7-5.7c-0.4-0.1-0.7-0.2-1.2-0.3c0.3-0.5,0.5-0.9,0.7-1.3c2.9-5,5.8-10.1,8.7-15.1c0.5-0.8,1-1.4,1.9-1.5
			c1.3-0.3,2.6-0.7,3.9-0.8c2-0.3,3.9,0.2,5.5,1.5c2.8,2.3,4.7,5.2,5.6,8.6c0.7,2.5,1,5,1.5,7.6c0.2,1.3,0.4,2.5,0.7,3.8
			c1.2,5.2,4.1,9.2,8.5,12.1c2.6,1.7,5.5,2.8,8.5,3.6c0.2,0,0.4,0.1,0.6,0.1c3.4,1,3.4,1,4.6,4.3c4.8,12.8,9.7,25.6,14.5,38.4
			C370.8,251.7,370.9,252.3,371.2,252.9z"/>
                                        <path class="st39" d="M357.8,257.5c-7,1.7-13.8,2.4-20.8,2.6c-0.7-1.1-0.6-2.2-0.7-3.3c-0.1-1.4-0.1-2.9-0.3-4.3
			c-0.7-6.6-4.4-10.7-10.5-12.7c-2.5-0.8-5-1-7.6-0.9c-1.8,0-3.5,0.1-5.3,0.1c-3.1,0.1-5.5-1.2-7.2-3.8c-1.3-2-2.1-4.2-2.7-6.4
			c-0.6-2.1-1-4.2-1.6-6.2c-0.2-0.8-0.4-1.7-0.7-2.5c-1.1-3.3-3.5-5.3-6.8-6.2c-0.5-0.2-1.1-0.3-1.8-0.4c0.3-0.5,0.4-0.9,0.7-1.3
			c3.3-5.8,6.7-11.6,10-17.3c0.5-0.8,1-1.2,2-1.1c3.9,0.2,6.9,2,9.3,5c2.4,3,3.6,6.5,4.1,10.2c0.3,2,0.4,4.1,0.9,6.1
			c0.4,1.8,1,3.7,1.8,5.4c1.9,3.8,5.1,5.8,9.2,6.4c2.4,0.3,4.7,0.6,7.1,0.9c1,0.2,2.1,0.4,3,0.8c4,1.4,6.7,4,7.8,8.1
			c0.6,2.2,1.1,4.5,1.5,6.8c0.6,3,1.4,5.8,3,8.4c1.3,2.1,2.9,3.9,5,5.2C357.4,257.1,357.5,257.2,357.8,257.5z"/>
                                        <path class="st54" d="M333.1,260.2c-1.6,0-3.2,0-4.8,0c-6.6-0.2-13.1-0.9-19.6-1.9c-5.8-0.9-11.6-2.4-17.2-4.1
			c-1-0.3-1.8-0.8-2.2-1.8c-0.5-1.2-1.1-2.4-1.5-3.7c-0.6-1.8-1-3.7-1.5-5.5c-0.6-2.1-1.5-4.1-2.9-5.7c-1-1.1-2.2-2.1-3.4-3.3
			c0.1-0.2,0.2-0.6,0.4-0.9c2.9-5,5.8-10.1,8.7-15.1c0.5-1,1.2-1.2,2.2-1.2c3,0.1,5.2,1.7,6,4.6c0.6,2,0.9,4,1.5,6
			c0.7,2.3,1.3,4.6,2.3,6.8c0.7,1.6,1.8,3.2,2.9,4.6c2.5,3,5.9,3.7,9.5,3.7c1.8,0,3.5-0.1,5.3-0.1c2.2,0,4.4,0.2,6.5,1
			c4.4,1.6,6.9,4.7,7.4,9.5C332.8,255.3,332.9,257.6,333.1,260.2z"/>
                                        <path class="st39" d="M353,205.2c-9.1-1.5-14.7-7.1-15.9-13.8c-0.4-2.4-0.8-4.8-1.2-7.2c-0.6-3.3-1.6-6.4-3.4-9.2
			c-1.1-1.8-2.6-3.4-4.2-4.8c-2.6-2.1-5.5-2.9-8.8-2.8c-0.4,0-0.7,0-1.3,0.1c4.1-7.2,8.2-14.2,12.2-21.2
			C331.2,147.2,352.2,202.1,353,205.2z"/>
                                        <path class="st44" d="M333.3,144.2c1.4-1.1,2.7-1.9,4.1-2.5c2.7-1.1,5.6-1.6,8.5-2c3.4-0.4,6.8-0.4,10.3-0.2
			c4.2,0.2,8.5,0.6,12.7-0.1c3.2-0.5,6.4-1.2,9.5-1.8c0.6-0.1,1.2-0.2,2-0.4c0.1,1,0.3,1.8,0.3,2.7c-0.5,4.5-1,9.1-1.5,13.6
			c-0.2,1.6-1.2,2.7-2.5,3.4c-2.1,1.3-4.5,1.5-6.9,1.2c-2.8-0.4-5.3-1.5-7.7-2.9c-3-1.8-6-3.6-8.9-5.4c-4.5-2.7-9.5-4.5-14.7-5.4
			c-1.2-0.2-2.4-0.1-3.6-0.2C334.3,144.3,333.9,144.2,333.3,144.2z"/>
                                        <path class="st43" d="M368.2,188c-0.5-0.3-1-0.6-1.4-1c-5.8-4.6-10.7-10-14.3-16.6c-2-3.6-4.1-7.2-6.1-10.8
			c-0.7-1.3-1.6-2.5-2.4-3.7c-2.1-3-4.6-5.7-8.1-7.8c0.9-0.2,1.6-0.1,2.3,0.1c4.4,0.9,8.6,2.3,12.5,4.7c3,1.8,6,3.6,9.1,5.4
			c3.7,2.2,7.6,3.6,12.1,3.8c0.1,1.1,0.2,2.2,0.2,3.4c0,4.5-0.1,9-0.8,13.4c-0.4,2.3-1,4.6-1.6,6.8C369.4,186.5,369,187.4,368.2,188
			z"/>
                                        <path class="st43" d="M330.6,141.4c0.8-2.2,2.1-4.2,3.8-5.8c1.2-1.1,2.4-2.1,3.7-3.1c2.8-2.1,5.7-4,8.5-6.1
			c4.2-3.1,7.8-6.8,10.3-11.4c0.6-1.1,1.1-2.2,1.7-3.4c0.5,0.3,1,0.6,1.5,0.9c3,2.2,6.1,4.5,9.1,6.6c0.8,0.6,1,1.3,0.8,2.2
			c-0.6,2.9-1.5,5.7-2.8,8.4c-1,2.1-2,4.2-3.1,6.4c-2.3-0.1-4.6-0.2-6.9-0.3c-4.4-0.2-8.8-0.3-13.1,0.4
			C339.3,136.9,334.6,138.2,330.6,141.4z"/>
                                        <path class="st39" d="M278,237.4c0.8,0.7,1.6,1.3,2.2,2c1.1,1.2,1.9,2.8,2.4,4.4c0.8,2.5,1.5,5.1,2.2,7.7c-2.1-0.2-8.7-4-11.2-6.4
			C275,242.6,276.4,240.1,278,237.4z"/>
                                    </g>
                                    <g>
                                        <path class="st39" d="M152.4,238.2c-1.4,0-2.9-0.5-4.3-1.2c-1.1-0.5-2.1-1.1-3.2-1.7c-1.4-0.7-2.3-0.6-3.5,0.6
			c-0.5,0.5-0.9,1.1-1.3,1.6c-1.7,2.1-3.7,3.1-6.4,2.8c-2.3-0.2-3.1,0.3-3.9,2.5c-0.3,0.8-0.5,1.7-1,2.4c-0.6,1.1-1.3,2.3-2.2,3.2
			c-1.8,2-4.1,2.7-6.8,1.9c-1.1-0.3-2.2-0.7-3.3-1.1c-1.6-0.7-2.9-0.2-4,1c-0.6,0.7-1.2,1.5-1.8,2.2c-2.2,2.5-4.8,4.5-8.1,5.3
			c-2.3,0.5-4.5,0.5-6.6-0.6c-1.6-0.8-3.2-1.7-4.7-2.7c-2-1.2-3-1.1-4.7,0.6c-1.1,1-2.2,2-3.4,2.8c-1.7,1.1-3.6,1.3-5.6,0.8
			c-0.3-0.1-0.7-0.2-1-0.3c-1.2-0.4-2.2,0-3,0.9c-0.5,0.6-0.9,1.2-1.3,1.7c-0.9,1.1-1.9,2-3.2,2.5c-3,1.4-6.3,0.1-7.6-3
			c-0.4-0.9-0.7-2-1-2.9c-0.6-2-1.6-2.6-3.7-2.3c-0.7,0.1-1.4,0.3-2.2,0.4c-1.5,0.2-2.6-0.6-3.1-2c-0.4-1.3-0.3-2.5,0.5-3.6
			c0.7-0.9,0.8-1.8,0.6-2.9c-0.4-2.2,0.2-4.2,1.1-6.1c1.2-2.4,4.4-3.6,7-2.6c1.1,0.4,2.2,1.1,3.2,1.6c1.5,0.8,2.4,0.7,3.3-0.8
			c2.2-3.5,7-4.1,10.2-2.1c1.1,0.7,2,1.6,3,2.5c0.6,0.5,1.1,1.2,1.7,1.7c1,0.9,2,0.8,3-0.1c0.2-0.2,0.3-0.3,0.4-0.5
			c2.1-2.7,4.9-3.9,8.3-4c0.9,0,1.7,0,2.6,0c2.4,0,3.1-0.6,3.2-3c0.1-2.1,0.6-4,1.6-5.8c0.8-1.5,1.9-2.6,3.4-3.5
			c2.4-1.3,4.8-1.4,7.1,0.3c1.1,0.8,2,1.9,3,2.8c0.6,0.6,1.1,1.3,1.7,2c1,1,2.4,0.9,3.2-0.4c0.1-0.1,0.1-0.2,0.2-0.3
			c2-4.3,5.5-5.9,10-6.1c1.1,0,2.2,0.1,3.3,0.2c0.4,0,0.8,0.1,1.2,0.1c1.4,0.1,2.2-0.4,2.7-1.7c0.3-0.7,0.5-1.5,0.7-2.2
			c0.5-1.6,1.3-3.1,2.7-4.2c1.6-1.3,3.4-1.8,5.4-1.7c0.7,0.1,1.4,0.1,2.1,0.1c1.2,0,1.9-0.6,2.2-1.8c0.1-0.6,0.2-1.3,0.3-1.9
			c0.2-1.3,0.7-2.4,1.5-3.4c1.1-1.4,2.6-2.2,4.4-1.8c1.8,0.4,3.3,1.4,3.8,3.3c0.4,1.2,0.4,2.4,0.6,3.7c0,0.3,0,0.6,0,0.9
			c0.1,2.2,0.8,2.9,2.7,3.2c1.9,0.3,3,1.6,3.7,3.2c0.4,0.8,0.2,1.6-0.4,2.2c-0.4,0.5-0.9,0.9-1.4,1.3c-0.6,0.4-1.2,0.7-1.8,1.1
			c-1.3,0.8-2.1,1.9-2.2,3.4c-0.2,2.2-0.9,4.3-2,6.2c-0.8,1.4-1.9,2.7-3.2,3.7C155.2,237.7,154,238.2,152.4,238.2z"/>
                                        <path class="st44" d="M96.4,233.4c-9.1,0.8-7.6,0.8-12.6,4.2c-0.1-1.6-0.2-3-0.3-4.5c-0.2-8.1-0.4-16.1-0.6-24.2
			c-0.2-6.3-0.3-12.7-0.5-19c-0.2-5.6-0.4-11.1-0.5-16.7c-0.2-7.7-0.3-15.4-0.4-23.1c0-0.7,0.2-1.2,0.6-1.7c0.8-1,1.5-2.1,2.3-3.1
			c11,26.7,22.1,53.5,33.2,80.4c-0.4-0.4-0.6-0.7-0.9-0.9c-1.2-1-2.2-2.2-3.5-3c-3.3-2-6.8-1.9-10.1,0.1c-3.7,2.2-5.6,5.6-6.4,9.7
			C96.6,232.1,96.5,232.7,96.4,233.4z"/>
                                        <path class="st43" d="M146,210.1c-6.8,0-10.2,3.8-11.8,9.8c-5.1-0.8-9.8-0.3-14,3.2c-0.4-1-0.9-1.8-1.2-2.6
			c-2.5-6-5-11.9-7.4-17.9c-7.8-19.1-15.7-38.2-23.5-57.2c-0.1-0.3-0.2-0.5-0.3-0.9c1.1,0.2,2.2,0.6,3.2,0.6c1,0,2.1-0.4,3.3-0.7
			C111.3,166,128.6,188,146,210.1z"/>
                                        <path class="st43" d="M73.8,151.3c1.5,0,2.9,0,4.4,0c0,0.2,0.1,0.5,0.1,0.8c0,2.3,0,4.6,0,6.9c0.1,6.2,0.3,12.3,0.5,18.5
			c0.1,3.7,0.2,7.4,0.3,11.1c0.2,6.9,0.4,13.8,0.5,20.7c0.1,3.1,0.1,6.2,0.2,9.3c0.1,4.7,0.3,9.4,0.5,14.1c0,0.7,0,1.5,0,2.2
			c-1.3-0.6-2.6-1.2-3.9-1.6c-1.4-0.5-2.8-0.6-4.2-0.3c-1.3,0.2-2.7,0.6-3.9,1.2c-1.2,0.6-2.3,1.7-3.5,2.6c-0.3-0.2-0.8-0.4-1.3-0.7
			C66.9,207.7,70.4,179.4,73.8,151.3z"/>
                                        <path class="st54" d="M71.1,124.4c0.1,0,0.2,0,0.3,0c2.2,0,2.8-0.5,3-2.6c0.2-2,1-3.7,2.4-5c2.2-2.2,5-1.7,6.4,1
			c0.4,0.8,0.7,1.7,1,2.5c0.2,0.6,0.3,1.2,0.6,1.7c0.5,1.2,1.5,1.8,2.8,1.5c0.9-0.2,1.8-0.2,2.6,0.3c1.6,0.9,2.1,2.4,1.4,4.1
			c-0.2,0.5-0.6,1.1-0.9,1.6c-1.4,2.1-1.3,2.9,0.4,4.8c0.6,0.7,1.2,1.4,1.6,2.2c0.6,1.2,0.7,2.5,0.2,3.8c-0.6,1.4-1.5,1.8-2.9,1.3
			c-0.8-0.3-1.6-0.8-2.4-1.3c-0.6-0.4-1.1-0.9-1.6-1.3c-1.6-1.2-2.9-0.8-3.5,1.2c-0.2,0.6-0.3,1.3-0.5,1.9c-0.4,1.6-1.1,3.1-2.3,4.3
			c-0.8,0.9-1.8,1.6-3,1.8c-1.1,0.2-1.9-0.1-2.5-1.1c-0.7-1.1-0.7-2.3-0.8-3.5c-0.1-1.5-0.5-2-1.9-2.2c-2.4-0.3-3.9-2.7-3.2-5
			c0.3-0.8,0.7-1.6,1.2-2.3c1-1.6,1-2.2-0.2-3.5c-1-1.2-1.3-2.5-1.1-4c0.2-1.5,1-2.1,2.5-2.1C70.7,124.4,70.9,124.4,71.1,124.4
			C71.1,124.4,71.1,124.4,71.1,124.4z"/>
                                    </g>
                                    <g>
                                        <path class="st54" d="M193.7,286.4c-1.3-6.6-5.2-10.5-11.7-12c1.9-5.8,3.7-11.5,5.5-17.3c4,0.9,7.6,0.3,10.9-1.9
			c2.7-1.8,4.6-4.2,5.6-7.2c1.2-3.5,1.1-7-0.3-10.4c-1.4-3.5-4.2-5.6-7.7-7c4.9-15.3,9.8-30.5,14.7-45.8c4.4,1.4,8.5,0.7,12.6-1.4
			c4.7,13.1,9.4,26.1,14.1,39.2c-3.8,2-6,5.1-6.9,9.2c-0.6,2.9-0.2,5.7,0.9,8.5c2.3,5.6,8.6,9.6,15.2,8.1c3,8.1,5.8,16.2,8.8,24.4
			c-2.2,1.6-4.1,3.5-5.7,5.7c-1.6,2.3-2.5,4.8-3.1,7.6c-0.6-0.4-1.1-0.7-1.6-1c-1.7-1.1-2.8-1-4.2,0.6c-0.9,1.1-1.8,2.2-2.7,3.2
			c-5.2,5.6-11.7,7.6-19.2,6.4c-6.2-0.9-11.4-3.9-16-8.1c-0.6-0.6-1.2-1.2-1.9-1.7c-1.2-1.1-2.6-1.3-4-0.6
			C195.9,285.4,194.9,285.9,193.7,286.4z M208.7,271.2c-0.5,5.9,2.4,10.6,7.5,13.5c1.6,0.9,3.3,1.1,5,0.8c4.9-0.7,8.4-3.3,10.6-7.8
			c0.7-1.3,1-2.7,1-4.2c0-3.7-1.4-6.8-3.7-9.6c-1.5-1.7-3.4-2.9-5.6-3.5C215,258.3,209.6,265.2,208.7,271.2z M225.3,217.1
			c0.2-3.2-0.9-6.4-3.1-8.7c-4.2-4.6-11.3-4.2-15,0.9c-2.7,3.7-2.5,7.6-0.8,11.5c1.4,3.1,3.8,5,7.2,5.6
			C219.4,227.4,224.9,223,225.3,217.1z"/>
                                        <path class="st44" d="M273.9,289.4c-0.4,2.4-0.8,4.5-1.2,6.5c-0.9,5.1-1.9,10.3-2.7,15.4c-0.1,0.9-0.6,1.2-1.3,1.6
			c-4.6,2-9.5,3.4-14.4,4.5c-7.9,1.7-15.9,2.8-24,2.9c-7.6,0.2-15.1-0.1-22.7-0.8c-8.8-0.8-17.5-2.2-26.1-4.1
			c-3.2-0.7-6.4-1.6-9.3-3.4c-0.5-0.3-0.8-0.7-0.9-1.3c-1.5-7.2-3-14.3-4.5-21.5c0-0.1,0-0.2,0-0.4c0.3,0.1,0.6,0.2,0.8,0.4
			c8,4.4,16.2,4.9,24.7,1.6c1.7-0.7,3.4-1.5,5.1-2.3c1.2-0.6,1.2-0.6,2.2,0.3c3.2,3.2,6.9,5.7,11,7.6c6.7,3,13.6,3.6,20.6,1.1
			c4-1.4,7.4-3.8,10.1-7c0.6-0.7,1.3-1.5,1.9-2.2C253.2,294.4,263.2,295.9,273.9,289.4z"/>
                                        <path class="st44" d="M232.4,152c-0.5,5.8-3.4,10.1-8.4,13c-1.2,0.7-2.8,1.1-4.3,1.3c-2.6,0.3-5.2,0-7.7-0.9
			c-5.8-2-10-7.9-9.7-14.1c0.1-2,0.4-4.1,1.1-6c0.6-1.6,1.7-3.3,3-4.5c4.2-3.6,9.2-5.3,14.7-4.6c7.4,1,11.3,7,11.4,13.8
			C232.6,150.8,232.4,151.4,232.4,152z"/>
                                        <path class="st39" d="M188.6,253.7c2.1-6.6,4.2-13.1,6.3-19.7c2.6,0.9,4.4,2.4,5.5,4.7c2.6,5.9-0.2,12.6-6.3,14.8
			C192.4,254.2,190.6,254.3,188.6,253.7z"/>
                                        <path class="st39" d="M238.5,226c2.3,6.4,4.5,12.6,6.8,18.9c-1,0.6-2,0.5-3,0.3c-5-1-8.5-5.2-8.6-10.3c-0.1-3.3,1.1-6.1,3.7-8.2
			C237.7,226.4,238,226.3,238.5,226z"/>
                                        <path class="st39" d="M190.3,287.7c-2.6,1.5-9.3,2.2-12.8,1.3c0-1,2.3-8.7,3.4-11.1C185,278.1,189.7,281.5,190.3,287.7z"/>
                                        <path class="st39" d="M256.6,276.2c1.7,4.6,3.3,9.1,4.9,13.7c-0.5,0-1,0.1-1.4,0.1c-3.1-0.1-6.1-0.6-9-1.6c-1.2-0.4-1.3-0.6-1.1-2
			c0.6-2.8,1.8-5.4,3.7-7.6C254.5,278,255.4,277.1,256.6,276.2z"/>
                                        <path class="st39" d="M217.9,168.6c1.4,3.8,2.7,7.5,4.1,11.3c-2.2,2.2-7.6,3-10.2,1.4c1.3-4.2,2.7-8.4,4-12.6
			C216.9,168.7,216.9,168.7,217.9,168.6z"/>
                                        <path class="st39" d="M221.5,263.6c1.6,0.1,3.2,0.8,4.5,2.1c2,1.9,3.2,4.4,3.4,7.2c0.1,1.3-0.1,2.5-0.7,3.7
			c-1.6,3-4.1,4.9-7.5,5.5c-1.5,0.3-2.8,0-4-0.8c-3.4-2.2-5.3-5.3-5.1-9.5c0.1-1.3,0.4-2.6,1.2-3.7c0.4-0.6,0.8-1.1,1.2-1.7
			C216.3,264.1,218.6,263.4,221.5,263.6z"/>
                                        <path class="st39" d="M208.7,215.3c0.3-3.5,2.3-5.9,5-6.6c2.6-0.6,5.3,0.5,6.9,2.9c1.1,1.7,1.6,3.5,1.3,5.5
			c-0.4,3.1-3.1,5.8-6.3,5.9c-2.2,0.1-4.1-0.9-5.4-2.8C209,218.6,208.6,216.7,208.7,215.3z"/>
                                    </g>
                                </g>
</svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-medium text-yellow-800">
                                Achtung - Geburtstag
                            </h3>
                            <div class="mt-2 text-sm leading-5 text-yellow-700">
                                @foreach($birthdays as $birthday)
                                    <p>
                                        <strong>{{ $birthday->name }} - {{ $birthday->birthday->format('d.m.Y') }}</strong>
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="bg-white px-3 py-2 rounded-b">
                @if (session('status'))
                    <div class="bg-green-lightest border border-green-light text-green-dark text-sm px-4 py-3 rounded mb-4">
                        {{ session('status') }}
                    </div>
                @endif



                @if($practise)
                    <div class="mt-2">
                        <div class="grid grid-cols-2">
                            <h3 class="mb-4 col-span-1">Meine Auswahl:</h3>
                            <div class="col-span-1">
                            <a href="{{ route('participate',['id' => $practise->id,'participate' => 1]) }}"><button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">JA</button></a>&nbsp;
                                <a href="{{ route('participate',['id' => $practise->id,'participate' => 0]) }}"><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">NEIN</button></a>

                                @if(\App\Draw::where('practise_id',$practise->id)->first())
                                    <a target="_blank" href="{{ route('shuffle',['id' => $practise->id]) }}"><strong><button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">Auslosung anzeigen!</button></strong></a>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 mt-4">
                            @if(!$beer)
                                <h3 class="mb-4 col-span-1">Ich bringe Bier mit:</h3>
                                <a class="col-span-1" href="{{ route('participate',['id' => $practise->id,'beer' => 1]) }}"><button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">JA</button></a>&nbsp;</h3>
                            @else
                                <h3 class="col-span-2">Danke an <strong> {{ $beer->user->name }}</strong>! {{ $beer->user->name }} bringt Bier mit!</h3>
                            @endif
                        </div>

                    </div>
                @endif
            </div>
            <div>
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg">
                        <table class="min-w-full">
                            <thead>
                            <tr class="border-b border-gray-700">
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs leading-4 font-bold text-black uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs leading-4 font-bold text-black uppercase tracking-wider">
                                    Ja
                                </th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs leading-4 font-bold text-black uppercase tracking-wider">
                                    Nein
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($practise)
                                @foreach($practise->participations as $participator)
                                    <tr class="@if($loop->even) bg-white @else bg-gray-50 @endif">
                                        <td class="px-4 py-2 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">{{ $participator->user->name }}</td>
                                        <td class="px-4 py-2 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">@if($participator->participate) X @endif</td>
                                        <td class="px-4 py-2 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">@if(!$participator->participate) X @endif</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if($practise)
                        @if((\Auth::user()->name == 'T-Man' || \Auth::user()->name == 'Übungsleiter') && !\App\Draw::where('practise_id',$practise->id)->first() && (\Carbon\Carbon::now() >= $practise->date_of_practise->subHours(3)))
                            <a target="_blank" class="mt-8" href="{{ route('shuffle',['id' => $practise->id]) }}"><strong><button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">Teams losen - Achtung nur 1 mal möglich!</button></strong></a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

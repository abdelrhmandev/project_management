<div class="{{ $div_class }}">
    <div style="text-align:center">
        <img src="{{ $logo }}"><br />
        <h1 class="mt-8"> عقد  مراقب</h1>
    </div>
    الحمد لله رب العالمين والصلاة والسلام على أشرف الأنبياء والمرسلين وعلى آله وصحبه الكرام وسلم وبعد،
    <h2>أنه في يوم {{ $today_day_arabic }} الموافق {{ date('d-m-Y') }} م ـ تم الاتفاق بين كل من:</h2>
    <ul style="list-style-type:square">
        <li><b> شركة محمد الفارس للدراسات وعنوانه الرياض، حي الياسمين، بموجب السجل التجاري رقم 1010611224، ويمثله في
                التوقيع سعادة الأستاذ/ محمد بن عبد الرحمن الفارس، بصفته الرئيس التنفيذي.</b></li>
        <li>
            <b>
                - الطرف الثاني السيد / {{ $user->name ?? '' }}&nbsp;،
                هوية وطنية رقم: {{ $user->national_id ?? '' }}،&nbsp;
                جوال رقم: {{ $user->mobile ?? '' }}،&nbsp;
                المنطقة: {{ $user->region->title ?? '' }}
                ،&nbsp;البريد الالكتروني :
                <span style="text-dir:ltr !important">{{ $user->email ?? '' }}</span>
                &nbsp;بما يلي:
            </b>
        </li>
    </ul>
    أ‌- تمهيد
    لما كـان الطرف الأول يملك عقد مشروع ({{ $project_title ?? '' }})، ولمـا كان الطرف الثـاني تتوفر لديـه المؤهلات
    والمهارات المطلوبـة لتنفيذ خدمات أعمال المشروع المذكور بوظيفة (مراقب) وحيث أن الطرف الأول قدم
    له العرض المالي قام بالموافقة عليه وقبل به وهما بكامل إرادتهما وأهليتهما الشرعيـة واتفقا على ما يلي:<br /><br />
    <u>المـادة الأولى: </u><br />
    يعد التمهيـد أعلاه جزء لا يتجزأ من هذا العقـد.<br /><br />
    <u>المادة الثانية: الغرض من العقد: </u><br />

    أن يقوم الطرف الثاني بإنجاز العمل الموكل إليه وفق تعليمات الطرف الأول والمهام والبنود الموضحة في المادة الثالثة
    والتي يمكن للطرف الأول تعديلها بما يحقق نجاح المشروع.<br /><br />
 
    <u>المادة الثالثة: التزامات الطرفين: </u>

    @include('pages.contracts.third_articles_types.observer')
    <u>المادة الرابعة: النزاعات: </u><br />
    أي خلاف ينشأ بين الطرفين بسبب تنفيذ هذا العقد أو تفسيره إذا لم يمكن حله بالطرق الودية فيما بينهما فإن الفصل يكون من
    محكم يتفق عليه الطرفان كتابيا، على أن يصدر المحكم قراره القطعي الملزم للطرفين خلال خمسة عشر يوما، فإن لم يتم ذلك فإن
    الفصل في النزاع يكون عن طريق جهات الاختصاص القضائي بالمملكة العربية السعودية في مدينة الرياض.<br />
    <div style="text-align:center !important">هذا والله الموفق .... </div>
    <br />
    @if ($preview_pdf)
    <table border="0" align="right" cellpadding="2" cellspacing="2" style="text-align:right !important">
        <tr>
            <td align="center"> الطرف الأول: </td>
        </tr>
        <tr>
            <td align="center">شركة محمد الفارس للدراسات</td>
        </tr>
    </table>
    <table border="0" align="left" cellpadding="2" cellspacing="2" style="text-align:left !important">
        <tr>
            <td align="center"> الطرف الثاني:</td>
        </tr>
        <tr>
            <td align="center">
                {{ $user->name ?? '' }}
            </td>
        </tr>
    </table>
    @else
    <div style="width:100%">
        <table border="0" align="center">
            <tr>
                <th>الطرف الأول: </th>
                <th>الطرف الثاني:</th>
            </tr>
            <tr>
                <td>شركة محمد الفارس للدراسات</td>
                <td>{{ $user->name ?? '' }}
                </td>
            </tr>
        </table>
    </div>
    @endif
</div>
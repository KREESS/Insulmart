@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse: collapse;">
    <tr>
        <td align="{{ $align }}" style="border: none;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse: collapse;">
                <tr>
                    <td align="{{ $align }}" style="border: none;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse: collapse;">
                            <tr>
                                <td style="border: none;">
                                    <a href="{{ $url }}"
                                       class="button button-{{ $color }}"
                                       target="_blank"
                                       rel="noopener"
                                       style="
                                           background-color: #8B0000;
                                           color: white;
                                           padding: 12px 24px;
                                           border-radius: 6px;
                                           text-decoration: none;
                                           display: inline-block;
                                           font-weight: 600;
                                           border: none;
                                           font-size: 16px;
                                           line-height: 1.5;
                                       ">
                                        {!! $slot !!}
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

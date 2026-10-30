<?php

namespace App\Services;

use DateTimeImmutable;
use Illuminate\Support\Facades\Crypt;
use PhpCfdi\Credentials\Pfx\PfxReader;
use PhpCfdi\XmlCancelacion\Capsules\Cancellation;
use PhpCfdi\XmlCancelacion\Credentials;
use PhpCfdi\XmlCancelacion\Models\CancelDocument;
use PhpCfdi\XmlCancelacion\Models\CancelDocuments;
use PhpCfdi\XmlCancelacion\Signers\DOMSigner;

/**
 * Summary of CancelationService
 */
class CancelationService
{
    /**
     * Summary of getCancelationXml
     * @param mixed $certificado
     * @param mixed $uuid
     * @return string
     */
    public function getCancelationXml($certificado, $uuid)
    {
        try {

            $pfxReader = new PfxReader();
            $pfxContents = base64_decode($certificado->pfx);
            $credentials = Credentials::createWithPhpCfdiCredential($pfxReader->createCredentialFromContents($pfxContents, Crypt::decrypt($certificado->password)));

            // datos de cancelación
            $data = new Cancellation(
                $certificado->rfc,
                new CancelDocuments(CancelDocument::newWithErrorsUnrelated($uuid)),
                new DateTimeImmutable()
            );

            $xml = (new DOMSigner())->signCapsule($data, $credentials);

            return $xml;
        } catch (\Throwable $e) {
            return ($e);
        }
    }

}

<?php


namespace Dex\Marketplace\Domain\Model;


use Dex\Marketplace\Domain\Exception\InvalidActionFileException;

/**
 * Class ProductImage Entity
 * @package Dex\Marketplace\Domain\Model
 */
class ProductImage
{
    private ProductId $productId;
    private string $identifierImage;
    private string $path;
    private string $filename;
    private string $created_at;

    public function __construct(
        ProductId $productId,
        string $path,
        string $filename,
        string $created_at
    )
    {
        $this->productId = $productId;
        $this->path = $path;
        $this->filename = $filename;
        $this->created_at = $created_at;
        $this->identifierImage = "";
    }

    public function isThisBelongsToProduct(ProductId $productId): bool
    {
        return $this->productId->getId() === $productId->getId();
    }

    public static function checkFileExist(string $path): bool
    {
        return is_file($path);
    }

    public static function checkFolderExist(string $folder): bool
    {
        return is_dir($folder);
    }

    public function saveImage()
    {
        if(!self::checkFolderExist($this->path)){
            $status = mkdir($this->path);
            if(!$status){
                return new InvalidActionFileException('Error create directory');
            }
        }

        return move_uploaded_file($this->filename, $this->path);
    }

    public function deleteImage(): bool
    {
        if (self::checkFileExist($this->path . $this->filename)) {
            $status = unlink($this->path . $this->filename);

            if ($status)
                return true;
            return false;
        }

        return false;
    }

    public function getProductImageId(): ProductId
    {
        return $this->productId;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getCreatedDate(): string
    {
        return $this->created_at;
    }
}

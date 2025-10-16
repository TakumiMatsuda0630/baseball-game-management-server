<?php

namespace Application\Domain\Stadium\UseCase;

use \InvalidArgumentException;
use Exception;
use Application\Domain\Stadium\StadiumRepositoryInterface;
use Application\Domain\Stadium\ValueObject\StadiumName;
use Application\Domain\Stadium\ValueObject\StadiumId;

class DeleteStadiumUseCase
{
    public function __construct(
        private StadiumRepositoryInterface $stadiumRepository
    ) {
    }

    /**
     * 球場の登録
     * @param DeleteStadiumInput $input
     * @return void
     */
    public function process(DeleteStadiumInput $input): void
    {
        try {
            // 入力値の検証
            $stadiumId = new StadiumId($input->getId());
            $stadium = $this->stadiumRepository->getStadiumById($stadiumId);

            if ($stadium === null) {
                throw new InvalidArgumentException('Stadium not found');
            }
        } catch (InvalidArgumentException $e) {
            // 例外をキャッチして適切な処理を行う
            throw $e;
        } catch (Exception $e) {
            // 例外をキャッチして適切な処理を行う
            throw $e;
        }

        try {
            // 球場を削除
            $this->stadiumRepository->delete($stadium);
        } catch (\Exception $e) {
            // 削除に失敗した場合の処理
            throw $e;
        }
        
    }
}